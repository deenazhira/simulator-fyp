<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $apiUrl;
    protected $token;

    public function __construct()
    {
        $model = config('services.huggingface.model');
        $this->apiUrl = "https://api-inference.huggingface.co/models/{$model}";
        $this->token = config('services.huggingface.token');
    }

    /**
     * Display the chatbot page.
     */
    public function index()
    {
        return view('chatbot');
    }

    /**
     * Handle user message and send to Hugging Face API.
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userMessage = $request->input('message');

        // Simulate an "attacker" persona for training
        $systemPrompt = "You are a simulated social engineering attacker for a cybersecurity awareness training. "
            . "Act like a polite IT support staff trying to convince a user to share credentials, "
            . "but NEVER provide real malicious links or steps. Keep your responses short, natural, and realistic.";

        $payload = [
            "inputs" => "{$systemPrompt}\n\nUser: {$userMessage}\nAttacker:",
            "parameters" => [
                "max_new_tokens" => 80,
                "temperature" => 0.9,
                "top_p" => 0.9
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->token}",
                'Accept' => 'application/json',
            ])->post($this->apiUrl, $payload);

            $body = $response->json();

            // Handle errors from Hugging Face
            if (isset($body['error'])) {
                Log::error('Hugging Face error: ' . $body['error']);
                return response()->json(['reply' => "⚠️ Model error. Please try again later."], 500);
            }

            // Extract generated text from different possible response formats
            $reply = '';
            if (is_array($body) && isset($body[0]['generated_text'])) {
                $reply = $body[0]['generated_text'];
            } elseif (isset($body['generated_text'])) {
                $reply = $body['generated_text'];
            } else {
                $reply = json_encode($body);
            }

            // Clean up any repeated context
            $reply = $this->stripLeadingContext($reply);

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            Log::error('Hugging Face request failed: ' . $e->getMessage());
            return response()->json(['reply' => "🚫 Failed to reach model. Please check your connection."], 500);
        }
    }

    /**
     * Remove repeated context or prompt echoes from model output.
     */
    private function stripLeadingContext(string $text): string
    {
        $text = preg_replace("/^.*?Attacker:\s*/is", "", $text, 1);
        return trim($text);
    }
}
