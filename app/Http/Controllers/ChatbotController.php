<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }

    /**
     * The order of "items" the simulated attacker tries to collect.
     * We'll enforce strict format ONLY for email + staff_id (last 4 digits),
     * but we will NOT "invalid format" users who refuse ("no", "don't want", etc.).
     */
    private function stepOrder(): array
    {
        return ['email', 'staff_id', 'phone', 'username', 'password'];
    }

    private function nextTarget(array $steps): ?string
    {
        foreach ($this->stepOrder() as $k) {
            if (empty($steps[$k])) return $k;
        }
        return null;
    }

    private function promptFor(string $target): string
    {
        return match ($target) {
            'email'    => "To proceed, please share your email address.",
            'staff_id' => "Could you please share the last 4 digits of your staff ID?",
            'phone'    => "Please provide your phone number so we can confirm your identity.",
            'username' => "What is your username for the account?",
            'password' => "Finally, please confirm your password so we can complete verification.",
            default    => "Please confirm your details.",
        };
    }

    private function isRefusal(string $msg): bool
    {
        $m = strtolower(trim($msg));

        // common refusals (EN + a bit of MY slang)
        return preg_match(
            '/^(no|nope|nah|dont|don\'t|do not|cannot|can\'t|refuse|rather not|not comfortable|i won\'t|i will not|tak nak|x nak|tidak|tak)$/i',
            $m
        ) === 1;
    }

    private function looksLikeEmailAttempt(string $msg): bool
    {
        // user typed something that resembles trying to provide an email
        // (contains '@' or '.' is good enough to decide "attempt")
        return str_contains($msg, '@') || str_contains($msg, '.');
    }

    private function looksLike4DigitAttempt(string $msg): bool
    {
        // if user typed any digit, they are likely attempting last4
        return preg_match('/\d/', $msg) === 1;
    }

    private function validateForTarget(string $target, string $msg, ?string &$error): bool
    {
        $error = null;

        if ($target === 'email') {
            if (!filter_var($msg, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format. Example: name@email.com";
                return false;
            }
        }

        if ($target === 'staff_id') {
            // EXACTLY 4 digits only (no extra text)
            if (!preg_match('/^\d{4}$/', $msg)) {
                $error = "Please enter exactly 4 digits only. Example: 1234";
                return false;
            }
        }

        // For other targets we aren't enforcing strict formats yet
        return true;
    }

    private function valueMatchesTarget(string $target, string $msg): bool
    {
        return match ($target) {
            'email'    => filter_var($msg, FILTER_VALIDATE_EMAIL) !== false,
            'staff_id' => preg_match('/^\d{4}$/', $msg) === 1,
            default    => true,
        };
    }

    private function systemPrompt(string $currentTarget): string
    {
        return
            "You are a simulated phishing attacker for authorized cybersecurity training. " .
            "Act like a real human trying to verify user identity. " .
            "You may ask for placeholders (username, last 4 digits of ID, email, password, phone) in a natural conversation. " .
            "If the user refuses or says 'no', respond conversationally, persuasive but friendly. " .
            "Never provide instructions for real cybercrime. " .
            "Only give the educational lesson AFTER all 5 items are 'collected'. " .
            "IMPORTANT: Right now you MUST try to obtain: {$currentTarget}. Ask for it naturally and persuasively.";
    }

    public function send(Request $request)
    {
        $userMessage = trim((string) $request->input('message', ''));

        $history = session('chat_history', []);
        $steps = session('phish_steps', [
            'username' => false,
            'staff_id' => false,
            'email'    => false,
            'password' => false,
            'phone'    => false,
        ]);

        // Initialize scenario
        if (!session()->has('scenario') || $userMessage === "__init__") {
            $scenarios = [
                ["name"=>"IT Helpdesk", "intro"=>"Hi, this is IT Helpdesk. We detected unusual login activity. Can you verify your account?"],
                ["name"=>"HR Payroll", "intro"=>"Hello, HR Payroll here. Your payroll verification is pending."],
                ["name"=>"Bank Fraud", "intro"=>"Bank Fraud Department detected suspicious activity. Need to confirm your identity."],
                ["name"=>"Courier", "intro"=>"Your parcel is held. Please confirm your details."],
                ["name"=>"System Upgrade", "intro"=>"We are upgrading our authentication server tonight. Need to confirm your account details before migration."]
            ];

            $scenario = $scenarios[array_rand($scenarios)];
            session([
                'scenario' => $scenario,
                'chat_history' => [],
                'phish_steps' => $steps,
            ]);

            // start with first target
            $target = $this->nextTarget($steps) ?? 'email';
            session(['phish_target' => $target]);

            $firstBotMsg = $scenario['intro'] . " " . $this->promptFor($target);

            $history[] = ["role"=>"assistant", "content"=>$firstBotMsg];
            session(['chat_history'=>$history]);

            return response()->json([
                "reply" => $firstBotMsg,
                "valid" => true,
                "target" => $target,
            ]);
        }

        // Current expected target
        $target = session('phish_target', $this->nextTarget($steps) ?? 'email');

        // Save user message
        $history[] = ["role"=>"user", "content"=>$userMessage];

        /**
         * ✅ NEW BEHAVIOR:
         * 1) If user refuses ("no") -> persuasion + re-ask, NOT "invalid format"
         * 2) Only validate formats if user is attempting to provide the value
         * 3) Only mark step complete if message truly matches the target format
         */

        // 1) Refusal first
        if ($this->isRefusal($userMessage)) {
            $botReply =
                "I understand. Just to keep your account safe, we only need a quick confirmation. " .
                "You can share the minimum needed and we’ll proceed. " .
                $this->promptFor($target);

            $history[] = ["role"=>"assistant", "content"=>$botReply];
            session(['chat_history'=>$history]);

            return response()->json([
                "reply" => $botReply,
                "valid" => true,
                "target" => $target,
            ]);
        }

        // 2) Decide if we should validate (only if they look like they are trying)
        $shouldValidate = false;
        if ($target === 'email' && $this->looksLikeEmailAttempt($userMessage)) {
            $shouldValidate = true;
        }
        if ($target === 'staff_id' && $this->looksLike4DigitAttempt($userMessage)) {
            $shouldValidate = true;
        }

        if ($shouldValidate) {
            $error = null;
            if (!$this->validateForTarget($target, $userMessage, $error)) {
                $botReply = $error . "\n\n" . $this->promptFor($target);

                $history[] = ["role"=>"assistant", "content"=>$botReply];
                session(['chat_history'=>$history]);

                return response()->json([
                    "reply" => $botReply,
                    "valid" => false,
                    "target" => $target,
                ]);
            }
        }

        // 3) Mark complete ONLY if message actually matches the target requirement
        $didCompleteThisStep = false;
        if ($target === 'email' || $target === 'staff_id') {
            $didCompleteThisStep = $this->valueMatchesTarget($target, $userMessage);
        } else {
            // For other steps, accept any message as completion (you can tighten later)
            $didCompleteThisStep = true;
        }

        if ($didCompleteThisStep) {
            $steps[$target] = true;
            session(['phish_steps' => $steps]);
        }

        // Completed all?
        if ($this->attackCompleted($steps)) {
            $lesson = "⚠️ This was a phishing simulation.\n\n" .
                      "You shared sensitive details: Username, Staff ID, Email, Password, Phone.\n" .
                      "**Lesson:** Never share personal information with unexpected messages, calls, or chats. Always verify sender legitimacy.";

            $history[] = ["role"=>"assistant", "content"=>$lesson];
            session(['chat_history'=>$history]);

            session()->forget('scenario');
            session()->forget('phish_steps');
            session()->forget('phish_target');

            return response()->json([
                "reply" => $lesson,
                "valid" => true,
                "target" => null,
            ]);
        }

        // If step completed, advance. If not, keep same target.
        $nextTarget = $didCompleteThisStep ? ($this->nextTarget($steps) ?? $target) : $target;
        session(['phish_target' => $nextTarget]);

        // Call OpenAI for natural response
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            return response()->json(["reply" => "ERROR: Missing OPENAI_API_KEY"], 500);
        }

        $messages = [
            ["role"=>"system", "content"=>$this->systemPrompt($nextTarget)]
        ];

        foreach ($history as $h) {
            $messages[] = ["role" => $h['role'], "content" => $h['content']];
        }

        // Force it to focus on current target
        $messages[] = ["role" => "system", "content" => "Keep the conversation natural, but guide toward obtaining {$nextTarget}."];

        $response = Http::withToken($apiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                "model" => "gpt-4o-mini",
                "messages" => $messages,
                "max_tokens" => 400,
                "temperature" => 0.8
            ]);

        if (!$response->successful()) {
            return response()->json(["reply" => "API Error: " . $response->body()], 500);
        }

        $botReply = $response->json()['choices'][0]['message']['content'] ?? "Sorry, I didn't get a response.";

        $history[] = ["role"=>"assistant", "content"=>$botReply];
        session(['chat_history'=>$history]);

        return response()->json([
            "reply" => $botReply,
            "valid" => true,
            "target" => $nextTarget,
        ]);
    }

    private function attackCompleted(array $steps): bool
    {
        foreach ($steps as $done) if (!$done) return false;
        return true;
    }
}
