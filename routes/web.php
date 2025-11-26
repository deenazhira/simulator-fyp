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

//chatbot
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');

//awareness
Route::get('/awareness', function () {
    return view('awareness');
})->name('awareness');
