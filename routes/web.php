<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Chat
Route::get('/chat', [ChatController::class, 'index'])->name('chat');
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
Route::post('/chat/clear', [ChatController::class, 'clear'])->name('chat.clear');

// Quiz
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
Route::get('/quiz/{quiz}/result', [QuizController::class, 'result'])->name('quiz.result');