<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FootballClubController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\BlogController;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\UserController;
use App\Http\Controllers\CabinetController;
>>>>>>> Stashed changes

Route::get('/', function () {
    return redirect()->route('clubs.index');
});

// Маршрути лабораторної 3
Route::resource('country', CountryController::class);
Route::resource('clubs', FootballClubController::class);

// Маршрути лабораторної 4 (Статистика)
Route::get('/stats', [StatsController::class, 'pages'])->name('stats.pages');
Route::get('/stats/detail', [StatsController::class, 'detail'])->name('stats.detail');
Route::get('/stats/clubs', [StatsController::class, 'clubStats'])->name('stats.clubs');

// Маршрути блогу
// Маршрут /blog/admin має бути ПЕРЕД resource, інакше його перехопить blog/{blog} (show)
Route::get('/blog/admin', [BlogController::class, 'admin'])->name('blog.admin');

// Керування командами (клубами) новини
Route::get('/blog/{blog}/teams', [BlogController::class, 'teamsEdit'])->name('blog.teams');
Route::post('/blog/{blog}/teams', [BlogController::class, 'teamsStore'])->name('blog.teams.store');

Route::resource('blog', BlogController::class);

// Сторінка контактів
Route::view('/contacts', 'contacts')->name('contacts');
<<<<<<< Updated upstream
=======

// ЗАХИЩЕНІ МАРШРУТИ
Route::middleware('auth')->group(function () {
    Route::get('/blog/admin', [BlogController::class, 'admin'])->name('blog.admin');
    Route::get('/blog/{blog}/teams', [BlogController::class, 'teamsEdit'])->name('blog.teams');
    Route::post('/blog/{blog}/teams', [BlogController::class, 'teamsStore'])->name('blog.teams.store');
    Route::resource('blog', BlogController::class)->except(['index', 'show']);
    Route::get('/cabinet', [CabinetController::class, 'index'])->name('cabinet');
});

// УПРАВЛІННЯ КОРИСТУВАЧАМИ (тільки admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
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
>>>>>>> Stashed changes
