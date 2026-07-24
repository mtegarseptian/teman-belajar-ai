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

        {{-- Elemen loading default kita sembunyikan karena sekarang ada di script --}}
        <div id="loadingBubble" class="hidden"></div>

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

// Alur utama untuk mengatur tombol saat pesan dikirim
async function sendMessage() {
    const text = input.value.trim();
    if (!text) return;

    input.value      = '';
    input.disabled   = true;
    sendBtn.disabled = true;
    
    addUserBubble(text);
    scrollBottom();

    await kirimPesan(text);

    input.disabled   = false;
    sendBtn.disabled = false;
    input.focus();
    scrollBottom();
}

// Logika stream untuk mengambil balasan dari server
// Logika stream untuk mengambil balasan dari server
async function kirimPesan(userText) {
    // 1. Buat bubble AI dengan animasi berpikir DAN teks informasinya
    const aiDiv = document.createElement('div');
    aiDiv.className = 'flex items-start gap-3 my-4 w-full';
    aiDiv.innerHTML = `
        <div class="w-9 h-9 bg-green-600 rounded-xl flex items-center justify-center text-lg flex-shrink-0 shadow text-white">🤖</div>
        <div class="bg-white border-2 border-green-100 rounded-2xl rounded-tl-none px-5 py-4 max-w-sm shadow-sm w-full">
            <div class="ai-text-content text-sm font-semibold text-slate-800 flex gap-1.5 items-center min-h-[24px]">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-bounce [animation-delay:0ms]"></span>
                <span class="w-2 h-2 bg-green-400 rounded-full animate-bounce [animation-delay:150ms]"></span>
                <span class="w-2 h-2 bg-green-400 rounded-full animate-bounce [animation-delay:300ms]"></span>
                <!-- Tambahan teks "sedang berpikir" di sini -->
                <span class="text-xs text-gray-400 ml-1 font-semibold">
                    Bio Buddy sedang berpikir...
                </span>
            </div>
            <p class="text-gray-400 text-xs mt-2 ai-timestamp hidden">Bio Buddy · ${now()}</p>
        </div>
    `;
    chatArea.insertBefore(aiDiv, loading);
    scrollBottom();

    const textContentElement = aiDiv.querySelector('.ai-text-content');
    const timestampElement = aiDiv.querySelector('.ai-timestamp');

    try {
        // 2. Fetch ke backend dengan mode stream
        const response = await fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'text/event-stream'
            },
            body: JSON.stringify({ message: userText, session_token: SESSION_TOKEN })
        });

        if (!response.ok) {
            throw new Error('Gagal terhubung ke server');
        }

        const reader = response.body.getReader();
        const decoder = new TextDecoder("utf-8");
        let aiFullText = "";
        
        // 3. Bersihkan animasi berpikir untuk mulai menulis teks
        textContentElement.innerHTML = "";
        textContentElement.className = "text-gray-700 text-sm leading-relaxed whitespace-pre-wrap"; 

        while (true) {
            const { done, value } = await reader.read();
            if (done) break;

            const chunk = decoder.decode(value, { stream: true });
            
            // Tangani limit error (429) dari OpenRouter
            if (chunk.includes('"error"') && !chunk.includes('data:')) {
                textContentElement.textContent = "Ups, Bio Buddy sedang kehabisan napas (limit request). Tunggu beberapa detik dan coba lagi ya! 😅";
                textContentElement.classList.add('text-red-500', 'font-bold');
                scrollBottom();
                break;
            }

            const lines = chunk.split('\n');

            for (const line of lines) {
                if (line.startsWith('data: ') && line.trim() !== 'data: [DONE]') {
                    try {
                        const parsed = JSON.parse(line.replace('data: ', ''));
                        if (parsed.choices && parsed.choices[0].delta.content) {
                            aiFullText += parsed.choices[0].delta.content;
                            // Gunakan textContent agar aman dari script berbahaya (XSS)
                            textContentElement.textContent = aiFullText;
                            scrollBottom();
                        }
                    } catch (e) {
                        // Abaikan error format data yang terpotong dari jaringan
                    }
                }
            }
        }
        
        // Tampilkan cap waktu ketika obrolan selesai
        timestampElement.classList.remove('hidden');

    } catch (error) {
        console.error('Chat Error:', error);
        textContentElement.textContent = "Ups, terjadi kesalahan sistem. Coba refresh halaman! 😅";
        textContentElement.classList.add('text-red-500', 'font-bold');
    }
}

// Mendaftarkan event pada form input dan tombol hapus
sendBtn.addEventListener('click', sendMessage);
input.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) { 
        e.preventDefault(); 
        sendMessage(); 
    }
});

document.getElementById('btnClear').addEventListener('click', async () => {
    if (!confirm('Reset semua chat? Percakapan akan dihapus.')) return;
    await fetch('{{ route("chat.clear") }}', {
        method: 'POST', 
        headers: { 'X-CSRF-TOKEN': CSRF }
    });
    window.location.reload();
});
</script>
@endpush