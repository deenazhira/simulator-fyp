<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TrainerAuth\RegisteredTrainerController;
use App\Http\Controllers\Auth\LoginController;

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


Route::get('/register/user', [RegisteredUserController::class, 'create'])->name('register.user');
Route::post('/register/user', [RegisteredUserController::class, 'store']);


Route::get('/register/trainer', [RegisteredTrainerController::class, 'create'])->name('register.trainer');
Route::post('/register/trainer', [RegisteredTrainerController::class, 'store']);

Route::get('/register', function () {
    return view('auth.register-choose');
})->name('register.choose');

// Login Routes
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
