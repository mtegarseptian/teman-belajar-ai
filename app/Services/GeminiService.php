<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * GeminiService
 *
 * Tanggung jawab SATU: mengirim request ke Gemini API dan mengembalikan teks balasan.
 * Tidak tahu tentang logika chat, prompt, atau knowledge base.
 */
class GeminiService
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        $model         = config('services.gemini.model', 'gemini-2.0-flash');
        $this->apiKey  = config('services.gemini.api_key');
        $this->apiUrl  = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";
    }

    /**
     * Kirim percakapan ke Gemini dan dapatkan balasan.
     *
     * @param  string  $systemPrompt   Instruksi sistem untuk AI
     * @param  array   $history        [ ['role' => 'user'|'model', 'message' => '...'], ... ]
     * @param  string  $userMessage    Pesan terbaru dari user
     * @return string
     *
     * @throws \Exception
     */
    public function generate(string $systemPrompt, array $history, string $userMessage): string
    {
        $contents = [];

        // Sisipkan system prompt sebagai turn pembuka user+model
        // (Gemini tidak punya field systemInstruction di semua versi,
        //  cara ini paling kompatibel)
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $systemPrompt]],
        ];
        $contents[] = [
            'role'  => 'model',
            'parts' => [['text' => 'Baik, saya mengerti. Saya siap membantu sesuai instruksi tersebut.']],
        ];

        // Tambahkan history percakapan sebelumnya (max 20 pesan)
        foreach (array_slice($history, -20) as $item) {
            $contents[] = [
                'role'  => $item['role'],   // 'user' atau 'model'
                'parts' => [['text' => $item['message']]],
            ];
        }

        // Tambahkan pesan user terbaru
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        $response = Http::timeout(30)->post(
            $this->apiUrl . '?key=' . $this->apiKey,
            [
                'contents'         => $contents,
                'generationConfig' => [
                    'temperature'     => 0.7,
                    'maxOutputTokens' => 800,
                ],
            ]
        );

        if ($response->failed()) {
            Log::error('GeminiService error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \Exception('Gemini API error: ' . $response->status());
        }

        $data = $response->json();

        return $data['candidates'][0]['content']['parts'][0]['text']
            ?? 'Maaf, terjadi kesalahan pada AI. Coba lagi ya!';
    }
}