<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected string $apiUrl;
    protected string $token;
    protected string $model;

    public function __construct()
{
    $this->token = config('services.huggingface.token');
    $this->model = config('services.huggingface.model');

    // FIX: use text-generation endpoint
    $this->apiUrl = "https://router.huggingface.co/hf-inference/text-generation/{$this->model}";
}

public function chat(Request $request)
{
    $request->validate(['message' => 'required|string|max:2000']);
    $userMessage = $request->message;

    try {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}",
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json'
        ])->post($this->apiUrl, [
            "inputs" => $userMessage,
            "parameters" => [
                "max_new_tokens" => 120,
                "temperature" => 0.7,
                "do_sample" => true,
                "system" =>
                "You are an attacker pretending to be IT Support. Start friendly, professional, then slowly escalate to asking for credentials."
            ]
        ]);

        $body = $response->json();

        Log::info("HF Response:", $body ?? []);

        // FIX: text-generation models return generated_text directly
        $reply =
            $body['generated_text']
            ?? $body[0]['generated_text']
            ?? "⚠️ Model returned empty response.";

        return response()->json(['reply' => trim($reply)]);

    } catch (\Throwable $e) {
        Log::error("HF Exception: ".$e->getMessage());
        return response()->json(['reply' => '⚠️ Communication error with HuggingFace.']);
    }
}

    public function index()
{
    return view('chatbot');
}

}
