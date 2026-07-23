@extends('layouts.app')
@section('title', 'Tanya AI')

@section('content')
<div class="flex flex-col h-screen">

    {{-- Header --}}
    <div class="bg-white border-b-2 border-green-100 px-6 py-4
                flex items-center gap-4 shadow-sm flex-shrink-0">
        <div class="relative">
            <div class="w-11 h-11 bg-green-600 rounded-2xl flex items-center
                        justify-center text-2xl shadow-md">🤖</div>
            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400
                         border-2 border-white rounded-full"></span>
        </div>
        <div>
            <p class="font-black text-green-800 text-base">Bio Buddy</p>
            <p class="text-green-500 text-xs font-semibold">
                Online · Siap membantu belajar IPA!
            </p>
        </div>
        <div class="ml-auto">
            <button id="btnClear"
                class="text-xs font-bold text-gray-400 hover:text-red-500
                       transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50">
                🗑 Reset Chat
            </button>
        </div>
    </div>

    {{-- Area Pesan --}}
    <div id="chatArea"
         class="flex-1 overflow-y-auto px-6 py-6 space-y-4
                bg-gradient-to-b from-green-50 to-white">

        {{-- Pesan selamat datang --}}
        @if($messages->isEmpty())
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 bg-green-600 rounded-xl flex items-center
                        justify-center text-lg flex-shrink-0 shadow">🤖</div>
            <div class="bg-white border-2 border-green-100 rounded-2xl rounded-tl-none
                        px-5 py-4 max-w-sm shadow-sm">
                <p class="text-gray-700 text-sm font-semibold leading-relaxed">
                    Halo! Aku <span class="text-green-700 font-black">Bio Buddy</span> 🧬
                </p>
                <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                    Aku asisten belajar IPA kamu. Silakan tanyakan tentang:
                </p>
                <ul class="mt-2 space-y-1 text-sm text-gray-500">
                    <li>🔬 Sel & Organel Sel</li>
                    <li>💧 Difusi & Osmosis</li>
                    <li>🫀 Jaringan & Organ</li>
                    <li>🌿 Sistem Organisasi Kehidupan</li>
                </ul>
                <p class="mt-3 text-sm text-green-600 font-bold">Yuk, mulai tanya! 😊</p>
            </div>
        </div>
        @endif

        {{-- History dari database --}}
        @foreach($messages as $msg)
            @if($msg->role === 'user')
            <div class="flex items-start gap-3 justify-end">
                <div class="bg-green-600 text-white rounded-2xl rounded-tr-none
                            px-5 py-4 max-w-sm shadow-sm">
                    <p class="text-sm font-semibold leading-relaxed">{{ $msg->message }}</p>
                    <p class="text-green-300 text-xs mt-1 text-right">
                        {{ $msg->created_at->format('H:i') }}
                    </p>
                </div>
                <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center
                            justify-center text-lg flex-shrink-0">🎒</div>
            </div>
            @else
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 bg-green-600 rounded-xl flex items-center
                            justify-center text-lg flex-shrink-0 shadow">🤖</div>
                <div class="bg-white border-2 border-green-100 rounded-2xl rounded-tl-none
                            px-5 py-4 max-w-sm shadow-sm">
                    <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
                    <p class="text-gray-400 text-xs mt-2">
                        Bio Buddy · {{ $msg->created_at->format('H:i') }}
                    </p>
                </div>
            </div>
            @endif
        @endforeach

        {{-- Loading bubble --}}
        <div id="loadingBubble" class="flex items-start gap-3 hidden">
            <div class="w-9 h-9 bg-green-600 rounded-xl flex items-center
                        justify-center text-lg flex-shrink-0 shadow">🤖</div>
            <div class="bg-white border-2 border-green-100 rounded-2xl rounded-tl-none
                        px-5 py-4 shadow-sm">
                <div class="flex gap-1.5 items-center">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-bounce [animation-delay:0ms]"></span>
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-bounce [animation-delay:150ms]"></span>
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-bounce [animation-delay:300ms]"></span>
                    <span class="text-xs text-gray-400 ml-1 font-semibold">
                        Bio Buddy sedang berpikir...
                    </span>
                </div>
            </div>
        </div>

    </div>

    {{-- Input Area --}}
    <div class="bg-white border-t-2 border-green-100 px-6 py-4 flex-shrink-0 shadow-lg">

        {{-- Quick Questions --}}
        <div class="flex gap-2 mb-3 overflow-x-auto pb-1">
            @foreach([
                ['🔬', 'Apa itu sel?'],
                ['⚡', 'Fungsi mitokondria?'],
                ['💧', 'Bedanya difusi & osmosis?'],
                ['🫀', 'Apa saja jaringan manusia?'],
                ['🌿', 'Apa itu tekanan turgor?'],
            ] as [$icon, $tanya])
            <button onclick="setQuestion('{{ $tanya }}')"
                class="flex-shrink-0 bg-green-50 border border-green-200 text-green-700
                       text-xs font-bold px-3 py-1.5 rounded-full
                       hover:bg-green-100 transition-colors whitespace-nowrap">
                {{ $icon }} {{ $tanya }}
            </button>
            @endforeach
        </div>

        {{-- Form --}}
        <div class="flex gap-3">
            <input id="messageInput" type="text"
                placeholder="Tulis pertanyaan kamu di sini... 🧬"
                autocomplete="off"
                class="flex-1 bg-green-50 border-2 border-green-200 rounded-2xl
                       px-5 py-3 text-sm font-semibold text-gray-700 placeholder-gray-400
                       outline-none focus:border-green-500 focus:bg-white transition-all" />
            <button id="sendBtn"
                class="bg-green-600 hover:bg-green-700 disabled:opacity-50
                       text-white font-black text-sm px-6 py-3 rounded-2xl
                       transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                Kirim <span>🚀</span>
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
const SESSION_TOKEN = '{{ $session->session_token }}';
const CSRF          = document.querySelector('meta[name="csrf-token"]').content;
const chatArea      = document.getElementById('chatArea');
const input         = document.getElementById('messageInput');
const sendBtn       = document.getElementById('sendBtn');
const loading       = document.getElementById('loadingBubble');

function scrollBottom() {
    chatArea.scrollTop = chatArea.scrollHeight;
}
scrollBottom();

function setQuestion(text) {
    input.value = text;
    input.focus();
}

function esc(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function now() {
    return new Date().toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
}

function addUserBubble(text) {
    const div = document.createElement('div');
    div.className = 'flex items-start gap-3 justify-end';
    div.innerHTML = `
        <div class="bg-green-600 text-white rounded-2xl rounded-tr-none px-5 py-4 max-w-sm shadow-sm">
            <p class="text-sm font-semibold leading-relaxed">${esc(text)}</p>
            <p class="text-green-300 text-xs mt-1 text-right">${now()}</p>
        </div>
        <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center text-lg flex-shrink-0">🎒</div>
    `;
    chatArea.insertBefore(div, loading);
}

function addAiBubble(text) {
    const div = document.createElement('div');
    div.className = 'flex items-start gap-3';
    div.innerHTML = `
        <div class="w-9 h-9 bg-green-600 rounded-xl flex items-center justify-center text-lg flex-shrink-0 shadow">🤖</div>
        <div class="bg-white border-2 border-green-100 rounded-2xl rounded-tl-none px-5 py-4 max-w-sm shadow-sm">
            <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">${esc(text)}</p>
            <p class="text-gray-400 text-xs mt-2">Bio Buddy · ${now()}</p>
        </div>
    `;
    chatArea.insertBefore(div, loading);
}

async function sendMessage() {
    const text = input.value.trim();
    if (!text) return;

    input.value      = '';
    sendBtn.disabled = true;
    addUserBubble(text);
    loading.classList.remove('hidden');
    scrollBottom();

    try {
        const res  = await fetch('{{ route("chat.send") }}', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body:    JSON.stringify({ message: text, session_token: SESSION_TOKEN }),
        });
        const data = await res.json();
        loading.classList.add('hidden');
        addAiBubble(data.message);
    } catch {
        loading.classList.add('hidden');
        addAiBubble('Ups, terjadi kesalahan. Coba lagi ya! 😅');
    }

    sendBtn.disabled = false;
    scrollBottom();
}

sendBtn.addEventListener('click', sendMessage);
input.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
});

document.getElementById('btnClear').addEventListener('click', async () => {
    if (!confirm('Reset semua chat? Percakapan akan dihapus.')) return;
    await fetch('{{ route("chat.clear") }}', {
        method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF }
    });
    window.location.reload();
});
</script>
@endpush