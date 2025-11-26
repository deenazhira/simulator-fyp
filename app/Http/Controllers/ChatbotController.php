<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot'); // show chatbot page
    }

    public function send(Request $request)
    {
        $msg = $request->message;

        $apiKey = env('HF_API_KEY'); // set this in .env
        $model = "Mistralai/Mixtral-8x7B-Instruct-v0.1";

        $url = "https://api-inference.huggingface.co/models/$model";

        $payload = json_encode(["inputs" => $msg]);

        $headers = [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result, true);
        $reply = $json['generated_text'] ?? $json[0]['generated_text'] ?? "No reply.";

        return response()->json(["reply" => $reply]);
    }
}
