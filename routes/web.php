<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FootballClubController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;

// Головна сторінка
Route::get('/', function () {
    return redirect()->route('clubs.index');
});

// Публічні маршрути
Route::resource('country', CountryController::class);
Route::resource('clubs', FootballClubController::class);

Route::get('/stats', [StatsController::class, 'pages'])->name('stats.pages');
Route::get('/stats/detail', [StatsController::class, 'detail'])->name('stats.detail');
Route::get('/stats/clubs', [StatsController::class, 'clubStats'])->name('stats.clubs');

// Сторінка контактів
Route::view('/contacts', 'contacts')->name('contacts');

// ЗАХИЩЕНІ МАРШРУТИ
Route::middleware('auth')->group(function () {
    Route::get('/blog/admin', [BlogController::class, 'admin'])->name('blog.admin');
    Route::get('/blog/{blog}/teams', [BlogController::class, 'teamsEdit'])->name('blog.teams');
    Route::post('/blog/{blog}/teams', [BlogController::class, 'teamsStore'])->name('blog.teams.store');
    Route::resource('blog', BlogController::class)->except(['index', 'show']);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// ПУБЛІЧНІ МАРШРУТИ БЛОГУ
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');

// Dashboard від Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Маршрути профілю Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Маршрути автентифікації Breeze
require __DIR__.'/auth.php';
