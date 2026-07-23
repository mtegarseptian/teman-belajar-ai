@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<div class="flex-1 flex flex-col items-center justify-center p-10
            bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 min-h-screen">

    {{-- Hero --}}
    <div class="text-center mb-10">
        <div class="text-8xl mb-5">🧬</div>
        <h1 class="text-4xl font-black text-green-800 mb-2">Teman Belajar AI</h1>
        <p class="text-green-600 font-bold text-base mb-2">
            Media Pembelajaran IPA Interaktif
        </p>
        <p class="text-gray-500 text-sm max-w-sm mx-auto leading-relaxed">
            Belajar <strong>Sistem Organisasi Kehidupan</strong> jadi lebih seru
            dengan bantuan AI dan kuis interaktif!
        </p>
    </div>

    {{-- Kartu Fitur --}}
    <div class="grid grid-cols-2 gap-5 w-full max-w-lg mb-10">

        <a href="{{ route('chat') }}"
           class="group bg-gradient-to-br from-green-500 to-green-700 rounded-3xl p-7
                  text-white shadow-lg hover:shadow-2xl hover:-translate-y-1
                  transition-all duration-200 text-center">
            <div class="text-5xl mb-3 group-hover:scale-110 transition-transform duration-200">🤖</div>
            <h2 class="text-xl font-black mb-1">Tanya AI</h2>
            <p class="text-green-100 text-xs leading-relaxed">
                Tanyakan apa saja tentang IPA, Bio Buddy siap membantu!
            </p>
        </a>

        <a href="{{ route('quiz.index') }}"
           class="group bg-gradient-to-br from-yellow-400 to-orange-500 rounded-3xl p-7
                  text-white shadow-lg hover:shadow-2xl hover:-translate-y-1
                  transition-all duration-200 text-center">
            <div class="text-5xl mb-3 group-hover:scale-110 transition-transform duration-200">🎯</div>
            <h2 class="text-xl font-black mb-1">Quiz</h2>
            <p class="text-yellow-100 text-xs leading-relaxed">
                Uji pemahamanmu dengan soal-soal literasi sains!
            </p>
        </a>

    </div>

    {{-- Info Topik --}}
    <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-green-100 w-full max-w-lg">
        <h3 class="font-black text-green-800 text-sm mb-4 text-center">
            📚 Topik yang Bisa Kamu Pelajari
        </h3>
        <div class="grid grid-cols-2 gap-2">
            @foreach([
                ['🔬', 'Sel & Organel',    'Mitokondria, ribosom, nukleus, dll'],
                ['💧', 'Difusi & Osmosis',  'Transportasi sel & tekanan turgor'],
                ['🫀', 'Jaringan',          'Epitel, ikat, otot, saraf'],
                ['🌿', 'Organ & Sistem',    'Hierarki organisasi kehidupan'],
            ] as [$icon, $judul, $desk])
            <div class="flex items-start gap-2 bg-green-50 rounded-2xl p-3">
                <span class="text-xl">{{ $icon }}</span>
                <div>
                    <p class="font-black text-green-800 text-xs">{{ $judul }}</p>
                    <p class="text-gray-400 text-xs mt-0.5">{{ $desk }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection