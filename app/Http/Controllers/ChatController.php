<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService) {}

    public function index(Request $request)
    {
        $token = $request->cookie('bio_session') ?? Str::uuid()->toString();
        $session = ChatSession::firstOrCreate(['session_token' => $token]);
        $messages = $session->messages()->orderBy('created_at')->get();

        return response()
            ->view('chat.index', compact('session', 'messages'))
            ->cookie('bio_session', $token, 60 * 24 * 7);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message'       => 'required|string|max:1000',
            'session_token' => 'required|string',
        ]);

        try {
            // Langsung kembalikan StreamedResponse
            return $this->chatService->reply(
                $request->session_token,
                $request->message
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ups, Bio Buddy sedang tidak bisa dihubungi. Coba lagi ya! 😅',
            ], 500);
        }
    }

    public function clear(Request $request)
    {
        $token = $request->cookie('bio_session');
        if ($token) {
            $this->chatService->clearSession($token);
        }
        return response()->json(['success' => true]);
    }
}