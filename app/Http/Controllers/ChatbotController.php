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

    public function send(Request $request)
    {
        // Debug: check API key is loaded
        // dd(env('OPENAI_API_KEY'));  <-- REMOVE THIS after testing

        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                "reply" => "ERROR: Missing API key in .env file."
            ]);
        }

        $response = Http::withToken($apiKey)->post(
            'https://api.openai.com/v1/chat/completions',
            [
                "model" => "gpt-4o-mini",
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "You are a phishing attacker simulation bot. Respond like a real attacker."
                    ],
                    [
                        "role" => "user",
                        "content" => $request->message ?? "Hello"
                    ]
                ]
            ]
        );

        if (!$response->successful()) {
            return response()->json([
                "reply" => "API Error: " . $response->body()
            ]);
        }

        return response()->json([
            "reply" => $response->json()['choices'][0]['message']['content']
        ]);
    }
}

