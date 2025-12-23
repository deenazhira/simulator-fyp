<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChatbotController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Quiz routes
Route::get('/quiz', [QuizController::class, 'welcome'])->name('quiz.welcome');
Route::get('/quiz/start/{q?}', [QuizController::class, 'showQuestion'])->name('quiz.start');
Route::post('/quiz/answer', [QuizController::class, 'answer'])->name('phish.quiz.answer');
Route::get('/quiz/finish', [QuizController::class, 'finish'])->name('quiz.finish');
Route::get('/quiz/result/{id}', [QuizController::class, 'showResult'])->name('quiz.result');



Route::get('/chat', [ChatbotController::class, 'index'])->name('chatbot');
Route::post('/chatbot/message', [ChatbotController::class, 'send'])->name('chatbot.message');

// Awareness page
Route::get('/awareness', function () {
    return view('awareness');
})->name('awareness');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
