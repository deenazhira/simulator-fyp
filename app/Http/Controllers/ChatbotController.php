<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected string $apiUrl;
    protected string $token;

    public function __construct()
    {
        $model = config('services.huggingface.model', env('HUGGINGFACE_MODEL', 'facebook/blenderbot-400M-distill'));
        // Use the new HF router endpoint
        $this->apiUrl = "https://router.huggingface.co/hf-inference/models/{$model}";
        $this->token = config('services.huggingface.token', env('HUGGINGFACE_API_TOKEN', ''));
    }

    /**
     * Show the chatbot page.
     */
    public function index()
    {
        return view('chatbot');
    }

    /**
     * Handle incoming user message and call Hugging Face Inference API.
     */
    public function chat(Request $request)
{
    // Validate user input
    $request->validate(['message' => 'required|string|max:2000']);
    $userMessage = trim($request->input('message'));

    try {
        // Send request to Hugging Face router
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_TOKEN'),
            'Accept' => 'application/json',
        ])->post('https://router.huggingface.co/hf-inference/text-generation/' . env('HUGGINGFACE_MODEL'), [
            'inputs' => $userMessage
        ]);

        $body = $response->json();

        // Get the bot reply safely
        $reply = $body[0]['generated_text'] ?? $body['generated_text'] ?? '🤖 Sorry, I could not generate a response.';

        return response()->json(['reply' => trim($reply)]);

    } catch (\Throwable $e) {
        return response()->json(['reply' => '⚠️ Failed to reach the model. Please try again later.']);
    }
}
}
