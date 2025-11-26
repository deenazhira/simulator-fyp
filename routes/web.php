<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChatbotController;

Route::get('/', function () {
    return view('home');
})->name('home');

//quiz
Route::get('/quiz', [QuizController::class, 'welcome'])->name('quiz.welcome');
Route::get('/quiz/start/{q?}', [QuizController::class, 'showQuestion'])->name('quiz.start');
Route::post('/quiz/answer', [QuizController::class, 'answer'])->name('phish.quiz.answer');
Route::get('/quiz/finish', [QuizController::class, 'finish'])->name('quiz.finish');
Route::get('/quiz/result/{id}', [QuizController::class, 'showResult'])->name('quiz.result');

Route::post('/chatbot/message', [App\Http\Controllers\ChatbotController::class, 'send'])
    ->name('chatbot.message');
Route::view('/chat', 'chatbot')->name('chatbot');
