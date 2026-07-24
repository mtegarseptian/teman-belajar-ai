<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl = 'https://openrouter.ai/api/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.key');
        $this->model = config('services.openrouter.model');
    }

    /**
     * Mengirim pesan ke AI secara biasa (tanpa efek mengetik)
     */
    public function askQuestion(string $userMessage, array $chatHistory = [], string $systemPrompt = '')
    {
        $messages = [];

        if (!empty($systemPrompt)) {
            $messages[] = ['role' => 'system', 'content' => $systemPrompt];
        }

        foreach ($chatHistory as $chat) {
            $messages[] = ['role' => $chat['role'], 'content' => $chat['content']];
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => config('app.url'), 
                'X-Title' => 'Teman Belajar AI',
            ])->post($this->baseUrl, [
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => 0.7, 
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('OpenRouter API Error: ' . $response->body());
            return "Ups, Bio Buddy sedang tidak bisa dihubungi. Coba lagi! 😅"; 

        } catch (\Exception $e) {
            Log::error('OpenRouter Exception: ' . $e->getMessage());
            return "Ups, Bio Buddy sedang tidak bisa dihubungi. Coba lagi! 😅"; 
        }
    }

    /**
     * Mengirim pesan secara streaming (Real-time Typing Effect)
     */
    public function askQuestionStream(string $userMessage, array $chatHistory, string $systemPrompt, callable $onComplete)
    {
        $messages = [];

        if (!empty($systemPrompt)) {
            $messages[] = ['role' => 'system', 'content' => $systemPrompt];
        }

        foreach ($chatHistory as $chat) {
            $messages[] = ['role' => $chat['role'], 'content' => $chat['content']];
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        return response()->stream(function () use ($messages, $onComplete) {
            $ch = curl_init($this->baseUrl);
            
            $fullResponse = ''; 
            
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => 0.7,
                'stream' => true
            ]));
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
                'HTTP-Referer: ' . config('app.url'),
                'X-Title: Teman Belajar AI'
            ]);
            
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $chunk) use (&$fullResponse) {
                echo $chunk;
                ob_flush();
                flush();
                
                $lines = explode("\n", $chunk);
                foreach ($lines as $line) {
                    if (strpos($line, 'data: ') === 0 && trim($line) !== 'data: [DONE]') {
                        $data = json_decode(substr($line, 6), true);
                        if (isset($data['choices'][0]['delta']['content'])) {
                            $fullResponse .= $data['choices'][0]['delta']['content'];
                        }
                    }
                }
                return strlen($chunk);
            });
            
            curl_exec($ch);
            curl_close($ch);
            
            if (is_callable($onComplete)) {
                $onComplete($fullResponse);
            }
            
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no'
        ]);
    }
}