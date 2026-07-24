<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatSession;

class ChatService
{
    public function __construct(
        protected OpenRouterService $openRouterService,
        protected PromptService   $promptService,
        protected KnowledgeService $knowledgeService
    ) {}

    public function reply(string $sessionToken, string $userMessage)
    {
        $session = ChatSession::where('session_token', $sessionToken)->firstOrFail();

        $history = $session->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'role'    => $m->role === 'model' ? 'assistant' : $m->role, 
                'content' => $m->message, 
            ])
            ->toArray();

        $context = $this->knowledgeService->getRelevantContext($userMessage);
        $systemPrompt = $this->promptService->buildSystemPrompt($context);

        ChatMessage::create([
            'chat_session_id' => $session->id,
            'role'            => 'user',
            'message'         => $userMessage,
        ]);

        return $this->openRouterService->askQuestionStream(
            $userMessage, 
            $history, 
            $systemPrompt, 
            function($fullAiReply) use ($session) {
                ChatMessage::create([
                    'chat_session_id' => $session->id,
                    'role'            => 'model',
                    'message'         => $fullAiReply,
                ]);
            }
        );
    }

    public function clearSession(string $sessionToken): void
    {
        $session = ChatSession::where('session_token', $sessionToken)->first();
        $session?->messages()->delete();
    }
}