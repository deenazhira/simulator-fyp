<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

Route::get('/', function () {
    return view('home');
})->name('home');

//quiz
Route::get('/quiz', [App\Http\Controllers\QuizController::class, 'index'])->name('quiz');
Route::post('/quiz/answer', [App\Http\Controllers\QuizController::class, 'answer'])->name('phish.quiz.answer');

//chatbot
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');
