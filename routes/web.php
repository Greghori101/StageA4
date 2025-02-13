<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProgramSessionController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CommunicationsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;

// Routes accessible to guests only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Protected routes (authentication required)
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('speakers', SpeakerController::class);
    Route::resource('program-sessions', ProgramSessionController::class)->except(['show']);
    Route::resource('communications', CommunicationsController::class)->except(['show']);
    Route::resource('sponsors', SponsorController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('questions', QuestionController::class);
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [HomeController::class, 'admin'])->name('admin.dashboard');

    Route::resource('admin/users', AdminUserController::class)->except(['show']);

    // Specific session routes
    Route::get('/program-sessions/{program_session}', [ProgramSessionController::class, 'show'])->name('program-sessions.show');

    // Sponsor category route
    Route::get('/sponsors/category/{category}', [SponsorController::class, 'showByCategory'])->name('sponsors.category');

    // Question management
    Route::prefix('questions')->group(function () {
        Route::put('/update-rejected/{id}', [QuestionController::class, 'updateRejetee'])->name('questions.update-rejected');
        Route::put('/validate/{id}', [QuestionController::class, 'valider'])->name('questions.validate');
        Route::put('/reject/{id}', [QuestionController::class, 'rejeter'])->name('questions.reject');
        Route::put('/process/{id}', [QuestionController::class, 'traiter'])->name('questions.process');
        Route::post('/{id}/reply', [QuestionController::class, 'repondre'])->name('questions.reply');
    });

    // Communication management
    Route::prefix('communications')->group(function () {
        Route::get('/create/{program_session_id}', [CommunicationsController::class, 'create'])->name('communications.create');
        Route::get('/{id}', [CommunicationsController::class, 'show'])->name('communications.show');
        Route::put('/{id}', [CommunicationsController::class, 'update'])->name('communications.update');
    });
});

// Sponsor dashboard
Route::middleware(['auth', 'role:sponsor'])->group(function () {
    Route::get('/sponsor', [HomeController::class, 'sponsor'])->name('sponsor.dashboard');
});

// Speaker dashboard
Route::middleware(['auth', 'role:speaker'])->group(function () {
    Route::get('/speaker', [HomeController::class, 'speaker'])->name('speaker.dashboard');
});
