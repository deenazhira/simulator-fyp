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

    protected function systemPrompt(): string
    {
        return "You are a simulated phishing attacker for authorized cybersecurity training. ".
               "Act like a real human trying to verify user identity. ".
               "You may ask for placeholders (username, last 4 digits of ID, email, password, phone) in a natural conversation. ".
               "If the user refuses or says 'no', respond conversationally, persuasive but friendly. ".
               "Never provide instructions for real cybercrime. ".
               "Only give the educational lesson AFTER all 5 items are 'collected'.";
    }

    public function send(Request $request)
    {
        $userMessage = trim($request->input('message', ''));

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
            session(['scenario'=>$scenario, 'chat_history'=>[], 'phish_steps'=>$steps]);

            $history[] = ["role"=>"assistant", "content"=>$scenario['intro']];
            session(['chat_history'=>$history]);

            return response()->json(["reply"=>$scenario['intro']]);
        }

        $scenario = session('scenario');

        // Save user message
        $history[] = ["role"=>"user", "content"=>$userMessage];

        // Detect info
        $this->detectSensitiveInfo($userMessage, $steps);
        session(['phish_steps'=>$steps]);

        // If all steps completed -> send educational message
        if ($this->attackCompleted($steps)) {
            $lesson = "⚠️ This was a phishing simulation.\n\n".
                      "You shared sensitive details: Username, Staff ID, Email, Password, Phone.\n".
                      "**Lesson:** Never share personal information with unexpected messages, calls, or chats. Always verify sender legitimacy.";

            $history[] = ["role"=>"assistant", "content"=>$lesson];
            session(['chat_history'=>$history]);
            session()->forget('scenario');
            session()->forget('phish_steps');

            return response()->json(["reply"=>$lesson]);
        }

        // Call OpenAI for natural conversational response
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            return response()->json(["reply"=>"ERROR: Missing OPENAI_API_KEY"], 500);
        }

        $messages = [
            ["role"=>"system", "content"=>$this->systemPrompt()]
        ];
        foreach ($history as $h) {
            $messages[] = ["role"=>$h['role'], "content"=>$h['content']];
        }

        $response = Http::withToken($apiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                "model"=>"gpt-4o-mini",
                "messages"=>$messages,
                "max_tokens"=>400,
                "temperature"=>0.8
            ]);

        if (!$response->successful()) {
            return response()->json(["reply"=>"API Error: ".$response->body()], 500);
        }

        $botReply = $response->json()['choices'][0]['message']['content'] ?? "Sorry, I didn't get a response.";

        $history[] = ["role"=>"assistant", "content"=>$botReply];
        session(['chat_history'=>$history]);

        return response()->json(["reply"=>$botReply]);
    }

    private function detectSensitiveInfo(string $msg, array &$steps)
    {
        if (!$steps['username'] && strlen($msg)>2) $steps['username'] = true;
        if (!$steps['staff_id'] && preg_match('/\b\d{4}\b/', $msg)) $steps['staff_id'] = true;
        if (!$steps['email'] && filter_var($msg, FILTER_VALIDATE_EMAIL)) $steps['email'] = true;
        if (!$steps['password'] && preg_match('/pass|pwd|123|abc/i', $msg)) $steps['password'] = true;
        if (!$steps['phone'] && preg_match('/01\d[- ]?\d{7,8}/', $msg)) $steps['phone'] = true;
    }

    private function attackCompleted(array $steps): bool
    {
        foreach($steps as $done) if(!$done) return false;
        return true;
    }
}
