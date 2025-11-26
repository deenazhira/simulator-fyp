<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        $msg = $request->message;

        $apiKey = env('HUGGINGFACE_KEY');   // from .env
        $model = "Mistralai/Mixtral-8x7B-Instruct-v0.1";

        $url = "https://api-inference.huggingface.co/models/$model";

        $payload = json_encode([
            "inputs" => $msg
        ]);

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

        if (isset($json[0]['generated_text'])) {
            $reply = $json[0]['generated_text'];
        } elseif (isset($json['generated_text'])) {
            $reply = $json['generated_text'];
        } else {
            $reply = "No reply from the model.";
        }

        return response()->json([
            "reply" => $reply
        ]);
    }
}
