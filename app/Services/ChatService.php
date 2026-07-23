<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatSession;

/**
 * ChatService
 *
 * Tanggung jawab: orkestrasi alur chat.
 * 1. Ambil/buat session
 * 2. Ambil history
 * 3. Minta konteks dari KnowledgeService
 * 4. Bangun prompt via PromptService
 * 5. Kirim ke GeminiService
 * 6. Simpan pesan & balasan
 */
class ChatService
{
    public function __construct(
        protected GeminiService   $geminiService,
        protected PromptService   $promptService,
        protected KnowledgeService $knowledgeService
    ) {}

    /**
     * Proses pesan user dan kembalikan balasan AI.
     *
     * @param  string  $sessionToken
     * @param  string  $userMessage
     * @return string  Balasan dari AI
     *
     * @throws \Exception
     */
    public function reply(string $sessionToken, string $userMessage): string
    {
        // 1. Ambil session (sudah pasti ada karena dibuat di controller)
        $session = ChatSession::where('session_token', $sessionToken)->firstOrFail();

        // 2. Ambil history percakapan
        $history = $session->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'role'    => $m->role,
                'message' => $m->message,
            ])
            ->toArray();

        // 3. Ambil konteks dari Knowledge Base (kosong untuk sekarang)
        $context = $this->knowledgeService->getRelevantContext($userMessage);

        // 4. Bangun system prompt
        $systemPrompt = $this->promptService->buildSystemPrompt($context);

        // 5. Simpan pesan user ke database
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'role'            => 'user',
            'message'         => $userMessage,
        ]);

        // 6. Kirim ke Gemini
        $aiReply = $this->geminiService->generate($systemPrompt, $history, $userMessage);

        // 7. Simpan balasan AI ke database
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'role'            => 'model',
            'message'         => $aiReply,
        ]);

        return $aiReply;
    }

    /**
     * Reset semua pesan dalam sebuah session.
     *
     * @param  string  $sessionToken
     * @return void
     */
    public function clearSession(string $sessionToken): void
    {
        $session = ChatSession::where('session_token', $sessionToken)->first();
        $session?->messages()->delete();
    }
}