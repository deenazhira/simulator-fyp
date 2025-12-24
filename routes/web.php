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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Home Route
Route::get('/', function () {
    return view('home');
})->name('home');

// 2. Authentication Routes
// Login
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Registration Selection
Route::get('/register', function () {
    return view('auth.register-choose');
})->name('register.choose');

// User Registration
Route::get('/register/user', [RegisteredUserController::class, 'create'])->name('register.user');
Route::post('/register/user', [RegisteredUserController::class, 'store']);

// Trainer Registration
Route::get('/register/trainer', [RegisteredTrainerController::class, 'create'])->name('register.trainer');
Route::post('/register/trainer', [RegisteredTrainerController::class, 'store']);


// 3. SMART DASHBOARD ROUTE (Crucial Logic)
// This handles the redirection: Trainer -> Trainer Dashboard, User -> User Dashboard
Route::get('/dashboard', function () {

    // Safety check: ensure user is actually logged in (though middleware handles this)
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // If Trainer -> Show the Trainer Dashboard Controller
    if (Auth::user()->user_role === 'trainer') {
        return app(TrainerDashboardController::class)->index();
    }

    // If Normal User -> Show the default user dashboard view
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');


// 4. Feature Routes
// Quiz
Route::get('/quiz', [QuizController::class, 'welcome'])->name('quiz.welcome');
Route::get('/quiz/start/{q?}', [QuizController::class, 'showQuestion'])->name('quiz.start');
Route::post('/quiz/answer', [QuizController::class, 'answer'])->name('phish.quiz.answer');
Route::get('/quiz/finish', [QuizController::class, 'finish'])->name('quiz.finish');
Route::get('/quiz/result/{id}', [QuizController::class, 'showResult'])->name('quiz.result');

// Chatbot
Route::get('/chat', [ChatbotController::class, 'index'])->name('chatbot');
Route::post('/chatbot/message', [ChatbotController::class, 'send'])->name('chatbot.message');

// Awareness
Route::get('/awareness', function () {
    return view('awareness');
})->name('awareness');


// 5. Specific Trainer Routes
// Allows direct access to trainer specific pages if needed
Route::middleware(['auth'])->group(function () {

    // Existing Dashboard Route
    Route::get('/trainer/dashboard', [TrainerDashboardController::class, 'index'])->name('trainer.dashboard');

    //Manage Users Routes
    Route::get('/trainer/users', [TrainerUserController::class, 'index'])->name('trainer.users.index');
    Route::delete('/trainer/users/{id}', [TrainerUserController::class, 'destroy'])->name('trainer.users.remove');

    //View Specific User Activity
Route::get('/trainer/users/{id}', [TrainerUserController::class, 'show'])->name('trainer.users.show');
});

// Feedback Routes
Route::get('/trainer/feedback/create/{quiz_result_id}', [TrainerFeedbackController::class, 'create'])->name('trainer.feedback.create');
Route::post('/trainer/feedback', [TrainerFeedbackController::class, 'store'])->name('trainer.feedback.store');

