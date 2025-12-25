<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TrainerAuth\RegisteredTrainerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TrainerDashboardController;
use App\Http\Controllers\TrainerUserController;
use App\Http\Controllers\TrainerFeedbackController;
use App\Http\Controllers\UserFeedbackController;

// ✅ IMPORTANT: Import the new middleware here
use App\Http\Middleware\EnsureTrainer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. PUBLIC ROUTES
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/awareness', function () {
    return view('awareness');
})->name('awareness');

// Authentication
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Registration
Route::get('/register', function () {
    return view('auth.register-choose');
})->name('register.choose');

Route::get('/register/user', [RegisteredUserController::class, 'create'])->name('register.user');
Route::post('/register/user', [RegisteredUserController::class, 'store']);

Route::get('/register/trainer', [RegisteredTrainerController::class, 'create'])->name('register.trainer');
Route::post('/register/trainer', [RegisteredTrainerController::class, 'store']);


// 2. PROTECTED ROUTES (Must be Logged In)
Route::middleware(['auth'])->group(function () {

    // Dashboard Logic
    Route::get('/dashboard', function () {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->user_role === 'trainer') {
            return app(TrainerDashboardController::class)->index();
        }
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');


    // Quiz Routes
    Route::get('/quiz', [QuizController::class, 'welcome'])->name('quiz.welcome');
    Route::get('/quiz/start/{q?}', [QuizController::class, 'showQuestion'])->name('quiz.start');
    Route::post('/quiz/answer', [QuizController::class, 'answer'])->name('phish.quiz.answer');
    Route::get('/quiz/finish', [QuizController::class, 'finish'])->name('quiz.finish');
    Route::get('/quiz/result/{id}', [QuizController::class, 'showResult'])->name('quiz.result');


    // Chatbot Routes
    Route::get('/chat', [ChatbotController::class, 'index'])->name('chatbot');
    Route::post('/chatbot/message', [ChatbotController::class, 'send'])->name('chatbot.message');


    // Feedback Routes (User)
    Route::get('/my-feedback', [UserFeedbackController::class, 'index'])->name('user.feedback.index');


    // --- TRAINER SPECIFIC ROUTES ---
    // ✅ FIX: Use 'EnsureTrainer::class' here instead of a function
    Route::middleware(EnsureTrainer::class)->group(function () {

        Route::get('/trainer/dashboard', [TrainerDashboardController::class, 'index'])->name('trainer.dashboard');

        Route::get('/trainer/users', [TrainerUserController::class, 'index'])->name('trainer.users.index');
        Route::delete('/trainer/users/{id}', [TrainerUserController::class, 'destroy'])->name('trainer.users.remove');
        Route::get('/trainer/users/{id}', [TrainerUserController::class, 'show'])->name('trainer.users.show');

        Route::get('/trainer/feedbacks', [TrainerFeedbackController::class, 'index'])->name('trainer.feedback.index');
        Route::get('/trainer/feedback/create/{quiz_result_id}', [TrainerFeedbackController::class, 'create'])->name('trainer.feedback.create');
        Route::post('/trainer/feedback', [TrainerFeedbackController::class, 'store'])->name('trainer.feedback.store');
    });

});

