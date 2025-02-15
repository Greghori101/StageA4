<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ProgramSessionController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('home.home');
})->name('home');

// Authentication Routes (Registration & Login)
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Users
Route::resource('users', UserController::class);

// Sponsors
Route::resource('sponsors', SponsorController::class);

// Speakers
Route::resource('speakers', SpeakerController::class);

// Rooms
Route::resource('rooms', RoomController::class);

// Questions
Route::resource('questions', QuestionController::class);

// Program Sessions
Route::resource('program_sessions', ProgramSessionController::class);

// Moderators
Route::resource('moderators', ModeratorController::class);

// Favorites
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

// Communications
Route::resource('communications', CommunicationController::class);
