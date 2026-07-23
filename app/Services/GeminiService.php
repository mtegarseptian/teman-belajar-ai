<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $model;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model  = config('services.gemini.model', 'gemini-2.5-flash');

        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent";
    }

    /**
     * Generate jawaban dari Gemini
     */
    public function generate(string $systemPrompt, array $history, string $userMessage): string
    {
        $contents = [];

        // Riwayat chat
        foreach ($history as $chat) {

            $contents[] = [
                'role' => $chat['role'],
                'parts' => [
                    [
                        'text' => $chat['message']
                    ]
                ]
            ];
        }

        // Pesan terbaru
        $contents[] = [
            'role' => 'user',
            'parts' => [
                [
                    'text' => $userMessage
                ]
            ]
        ];

        $payload = [

            'systemInstruction' => [

                'parts' => [
                    [
                        'text' => $systemPrompt
                    ]
                ]
            ],

            'contents' => $contents,

            'generationConfig' => [

                'temperature' => 0.7,
                'maxOutputTokens' => 800,
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => $this->apiKey,
        ])
        ->timeout(30)
        ->post($this->apiUrl, $payload);

        if ($response->failed()) {

            Log::error('Gemini Error', [

                'status' => $response->status(),
                'body'   => $response->body(),

            ]);

            throw new \Exception($response->body());
        }

        $json = $response->json();

        return $json['candidates'][0]['content']['parts'][0]['text']
            ?? 'Maaf, saya tidak dapat memberikan jawaban.';
    }
}