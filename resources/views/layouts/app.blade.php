<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name') }} — @yield('title', 'Belajar IPA')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap"
          rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-green-50">

<div class="flex h-full min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-64 bg-white shadow-xl flex flex-col fixed inset-y-0 left-0 z-20">

        {{-- Logo --}}
        <div class="p-5 bg-gradient-to-br from-green-500 to-green-700">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-white/20 rounded-2xl flex items-center justify-center text-2xl">
                    🧬
                </div>
                <div>
                    <p class="text-white font-black text-base leading-tight">Teman Belajar AI</p>
                    <p class="text-green-200 text-xs font-semibold">Asisten IPA Kamu!</p>
                </div>
            </div>
        </div>

        {{-- Tagline --}}
        <div class="px-5 py-3 bg-green-50 border-b border-green-100">
            <div class="flex items-center gap-2">
                <span class="text-lg">🎒</span>
                <div>
                    <p class="text-green-800 font-bold text-xs">Siswa IPA SMP</p>
                    <p class="text-green-500 text-xs">Semangat belajar! 🌟</p>
                </div>
            </div>
        </div>

        {{-- Navigasi --}}
        <nav class="flex-1 p-4 space-y-1">

            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all
                      {{ request()->routeIs('home')
                          ? 'bg-green-600 text-white shadow-md'
                          : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                <span class="text-lg">🏠</span>
                <span>Beranda</span>
            </a>

            <a href="{{ route('chat') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all
                      {{ request()->routeIs('chat*')
                          ? 'bg-green-600 text-white shadow-md'
                          : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                <span class="text-lg">🤖</span>
                <span>Tanya AI</span>
            </a>

            <a href="{{ route('quiz.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all
                      {{ request()->routeIs('quiz*')
                          ? 'bg-green-600 text-white shadow-md'
                          : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                <span class="text-lg">📝</span>
                <span>Quiz</span>
            </a>

        </nav>

        {{-- Footer Sidebar --}}
        <div class="p-4 border-t border-green-100 text-center">
            <p class="text-xs text-gray-400 font-semibold">Sistem Organisasi Kehidupan</p>
            <p class="text-xs text-gray-300">IPA SMP 🔬</p>
        </div>

    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 ml-64 flex flex-col min-h-screen">
        @yield('content')
    </main>

</div>

@stack('scripts')
</body>
</html>