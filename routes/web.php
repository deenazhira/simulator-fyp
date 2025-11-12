<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChatbotController;

Route::get('/', function () {
    return view('home');
})->name('home');

//quiz
// Quiz welcome page
Route::get('/quiz', [QuizController::class, 'welcome'])->name('quiz');
// Show question page (after clicking start)
Route::get('/quiz/start', [QuizController::class, 'showQuestion'])->name('quiz.start');
// Submit answer
Route::post('/quiz/answer', [QuizController::class, 'answer'])->name('phish.quiz.answer');

//chatbot
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');
