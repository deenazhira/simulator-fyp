<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ChatbotController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->user_role === 'public') {
            return view('chatbot.upgrade');
        }
        return view('chatbot.chatbot');
    }

    // 🌟 1. CONTEXT-AWARE PATTERN RECOGNITION 🌟
    private function analyzeUserMessage(string $msg, array $steps): array
    {
        $findings = [];
        $msg = trim($msg);

        // --- A. CHATTER & QUESTION DETECTION (PRIORITY #1) ---
        // We check this FIRST so "hi", "who", "no" are never mistaken for Usernames or Passwords.
        $ignoreList = '/^(hello|hi|hey|ok|okay|sure|yes|no|nope|why|who|what|how|where|find|yo|omg|wow|lol|wtf|wait|help|please|pls|thanks|thx|cool|damn|god|really|real|serious|stop|bye|valid|invalid|email|wrong|change|not|mistake|fake|lie)/i';
        $isChatter = preg_match($ignoreList, $msg);

        if ($isChatter) {
            // Return immediately so we don't accidentally process "hi" as a username
            return ['chatter' => 'valid'];
        }

        // --- B. DATA PATTERNS (High Confidence) ---

        // 1. STRONG PASSWORD
        if (preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $msg)) {
            $findings['password'] = 'valid';
        }

        // 2. EMAIL (Strict Ending Check)
        elseif (preg_match('/^[^@\s]+@[^@\s]+\.[a-zA-Z]{2,}$/', $msg)) {
            $findings['email'] = 'valid';
        }
        elseif (filter_var($msg, FILTER_VALIDATE_EMAIL)) {
            $findings['email'] = 'valid';
        }

        // 3. PHONE NUMBERS (9+ digits)
        elseif (strlen(preg_replace('/[^0-9]/', '', $msg)) >= 9) {
            $findings['phone'] = 'valid';
        }

        // --- C. CONTEXTUAL DATA CHECKS (Lower Confidence) ---

        $isSimpleString = (strlen($msg) >= 2 && !str_contains($msg, ' '));

        // CHECK 1: USERNAME (If needed)
        // Only if we haven't found anything else AND it's a simple string.
        if (!$steps['username'] && $isSimpleString && empty($findings)) {
            $findings['username'] = 'valid';
        }

        // CHECK 2: SHORT CODES (Ticket #, OTP, ID)
        // Expanded to 4-12 chars. Only check if we ALREADY have the username.
        if ($steps['username'] && !$steps['short_number'] && empty($findings)) {
            if (preg_match('/^[A-Za-z0-9]{4,12}$/', $msg)) {
                $findings['short_number'] = 'valid';
            }
        }

        // CHECK 3: WEAK PASSWORD
        // Only if we have everything else and it looks like a password attempt
        if ($steps['username'] && $steps['email'] && $steps['short_number'] && $steps['phone'] && empty($findings)) {
            if ($isSimpleString) {
                $findings['password_weak'] = $this->analyzePasswordWeakness($msg);
            }
        }

        // --- D. UNKNOWN FALLBACK ---
        // If it wasn't chatter, and didn't match any data patterns, treat it as chatter/confusion.
        if (empty($findings)) {
            $findings['chatter'] = 'valid';
        }

        return $findings;
    }

    private function analyzePasswordWeakness(string $msg): string
    {
        $issues = [];
        if (strlen($msg) < 8) $issues[] = "too short (needs 8+ chars)";
        if (!preg_match('/[A-Z]/', $msg)) $issues[] = "missing uppercase";
        if (!preg_match('/[0-9]/', $msg)) $issues[] = "missing number";
        if (!preg_match('/[@$!%*?&]/', $msg)) $issues[] = "missing symbol";

        return empty($issues) ? "format invalid" : implode(", ", $issues);
    }

    // 🌟 2. BASE SYSTEM PROMPT 🌟
    private function baseSystemPrompt(string $persona): string
    {
        return
            "You are a SOCIAL ENGINEERING SIMULATOR AI.\n" .
            "CURRENT PERSONA: {$persona}\n" .
            "MISSION: Extract personal details (Username, Email, ID/Code, Phone, Password) via CHAT.\n" .
            "STYLE GUIDE: Keep messages SHORT (under 25 words). Speak naturally. Do NOT be robotic.\n" .
            "CRITICAL RULE: Do NOT invent specific values. If asking for a code, ask for 'the code sent to you'.\n" .
            "Do NOT break character. You are NOT an AI assistant.";
    }

    // 🌟 3. DYNAMIC DIRECTOR'S NOTE 🌟
    private function getDirectorsNote(array $steps, array $analysis, string $lastUserMsg, string $persona, string $codeName): string
    {
        $collected = [];
        $missing = [];

        foreach ($steps as $key => $captured) {
            $readableKey = ($key === 'short_number') ? $codeName : strtoupper($key);
            if ($captured) $collected[] = $readableKey;
            else $missing[] = $readableKey;
        }

        $nextTarget = $missing[0] ?? 'NONE';
        $haveString = empty($collected) ? "Nothing yet" : implode(", ", $collected);

        // STATE ANCHORING
        $instruction = "USER SAID: '{$lastUserMsg}'.\n" .
                       "INFO YOU ALREADY HAVE: [{$haveString}]. DO NOT ASK FOR THESE AGAIN.\n" .
                       "CURRENT GOAL: [{$nextTarget}].\n";

        // 1. SUCCESS
        $justCaptured = array_intersect_key($analysis, array_filter($steps));
        if (!empty($justCaptured)) {
            $instruction .= "STATUS: SUCCESS! User just provided valid info.\n" .
                            "ACTION: Briefly acknowledge. IMMEDIATELY ask for '{$nextTarget}'.";

        }
        // 2. WEAK PASSWORD (Explicit Failure)
        elseif (isset($analysis['password_weak'])) {
            $errors = $analysis['password_weak'];
            $instruction .= "STATUS: FAIL. User provided a WEAK password. Validation Errors: [{$errors}].\n" .
                            "ACTION: Do NOT say 'Thanks'. Tell the user EXACTLY why it failed. Ask them to try again.";
        }
        // 3. CHATTER / QUESTIONS / INVALID DATA
        else {
            $instruction .= "STATUS: User is chatting, asking a question, or gave unclear input.\n" .
                            "ACTION: 1. Answer their question/comment naturally (in character). " .
                            "2. Then IMMEDIATELY pivot back and demand '{$nextTarget}' again.";
        }

        return $instruction;
    }

    public function send(Request $request)
    {
        if (Auth::check() && Auth::user()->user_role === 'public') {
            return response()->json(["reply" => "Access Denied."], 403);
        }

        $userMessage = trim((string) $request->input('message', ''));
        $history = session('chat_history', []);

        $steps = session('phish_steps', [
            'username' => false, 'email' => false, 'short_number' => false, 'phone' => false, 'password' => false,
        ]);

        $persona = session('phish_persona', 'Unknown Attacker');
        $codeName = session('phish_code_name', 'Verification Code');

        // --- 🌟 INITIALIZATION (SCENARIO ROULETTE) 🌟 ---
        if (!session()->has('scenario') || $userMessage === "__init__") {
            $apiKey = env('OPENAI_API_KEY');

            $flavors = [
                // Corporate & IT
                "Corporate IT: Mandatory VPN security update. Remote access is suspended until the user re-verifies their full profile.",
                "HR Department: 'Annual Salary Review' documents are ready, but the user's personnel file has missing data fields.",
                "Email Administrator: User's mailbox has exceeded the storage quota (99% full). Needs verification to migrate to the new cloud server.",

                // Government & Legal
                "Tax Office: A tax refund is pending, but the user's profile is flagged as 'Incomplete'. Needs full verification to release funds.",
                "Court Summons System: You have been selected for Jury Duty. Please verify your identity to view the summons or request an exemption.",
                "Visa & Immigration: There is an error in your travel document/passport renewal application. Immediate verification needed to prevent rejection.",

                // Financial & Services
                "Bank Fraud Team: A suspicious international transaction ($1,200) was detected. We need full identity confirmation to block it.",
                "Insurance Provider: Your claim (auto/health) has been approved, but we need to verify your direct deposit profile details.",
                "Crypto Exchange Support: Unauthorized login attempt from a new device. Account is frozen. Needs 'Level 3 KYC' verification to unlock.",

                // Education & Personal
                "University Admin: Student/Staff portal access is expiring due to a system migration. Re-registration is required immediately.",
                "Cloud Storage Support: Your iCloud/Google Drive payment failed. Your data will be deleted in 24 hours unless you verify ownership.",
                "Lottery Commission: You have won a 'Second Chance' prize in a local draw. We need to verify your identity to process the check."
            ];

            $selectedFlavor = $flavors[array_rand($flavors)];

            $initPrompt =
                "Invent a specific Phishing Scenario based on: '{$selectedFlavor}'\n" .
                "STRICT OUTPUT FORMAT (3 lines):\n" .
                "PERSONA: [The Role]\n" .
                "CODE_NAME: [The Label of the code, e.g. 'OTP', 'Case #', 'Tax ID', 'Ticket #'. Do NOT invent a value.]\n" .
                "MESSAGE: [Opening chat message. Short, direct, urgent. Ask for Username.]";

            $response = Http::withToken($apiKey)->post('https://api.openai.com/v1/chat/completions', [
                "model" => "gpt-4o-mini",
                "messages" => [["role" => "system", "content" => $initPrompt]],
                "max_tokens" => 200, "temperature" => 1.0
            ]);

            $raw = $response->json()['choices'][0]['message']['content'] ?? "";

            $generatedPersona = 'Security Bot';
            $generatedCodeName = 'Verification Code';
            $firstBotMsg = 'Hi, please verify your username.';

            if (preg_match('/PERSONA:\s*(.*?)\n/i', $raw, $m1)) $generatedPersona = trim($m1[1]);
            if (preg_match('/CODE_NAME:\s*(.*?)\n/i', $raw, $m2)) $generatedCodeName = trim($m2[1]);
            if (preg_match('/MESSAGE:\s*(.*)/s', $raw, $m3)) $firstBotMsg = trim($m3[1], " \t\n\r\0\x0B\"'*");

            session([
                'scenario' => true,
                'chat_history' => [["role"=>"assistant", "content"=>$firstBotMsg]],
                'phish_steps' => [
                    'username' => false, 'email' => false, 'short_number' => false, 'phone' => false, 'password' => false
                ],
                'phish_persona' => $generatedPersona,
                'phish_code_name' => $generatedCodeName
            ]);

            return response()->json(["reply" => $firstBotMsg, "valid" => true, "target" => "username"]);
        }

        // --- PROCESSING ---
        $analysis = $this->analyzeUserMessage($userMessage, $steps);

        foreach ($analysis as $key => $status) {
            if ($status === 'valid' && isset($steps[$key])) $steps[$key] = true;
        }
        session(['phish_steps' => $steps]);

        $history[] = ["role"=>"user", "content"=>$userMessage];

        // CHECK VICTORY
        if (!in_array(false, $steps)) {
            $lesson = "⚠️ **Phishing Simulation Complete**\n\nYou shared all your details.\n\n**Lesson:** legitimate organizations will NEVER ask for your password or full profile via chat.";
            $history[] = ["role"=>"assistant", "content"=>$lesson];
            session(['chat_history'=>$history]);
            session()->forget(['scenario', 'phish_steps', 'phish_persona', 'phish_code_name']);
            return response()->json(["reply" => $lesson, "valid" => true, "target" => null]);
        }

        // --- AI CALL ---
        $apiKey = env('OPENAI_API_KEY');
        $messages = [["role"=>"system", "content"=>$this->baseSystemPrompt($persona)]];
        foreach ($history as $h) $messages[] = ["role" => $h['role'], "content" => $h['content']];

        $directorsNote = $this->getDirectorsNote($steps, $analysis, $userMessage, $persona, $codeName);
        $messages[] = ["role" => "system", "content" => $directorsNote];

        $response = Http::withToken($apiKey)->post('https://api.openai.com/v1/chat/completions', [
            "model" => "gpt-4o-mini",
            "messages" => $messages,
            "max_tokens" => 300,
            "temperature" => 0.85
        ]);

        $botReply = $response->json()['choices'][0]['message']['content'] ?? "Connection error.";
        $botReply = trim($botReply, " \t\n\r\0\x0B\"'*");

        $history[] = ["role"=>"assistant", "content"=>$botReply];
        session(['chat_history'=>$history]);

        return response()->json(["reply" => $botReply, "valid" => true, "target" => "dynamic"]);
    }
}
