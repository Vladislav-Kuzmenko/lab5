<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FootballClubController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\BlogController;

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
Route::resource('blog', BlogController::class);

// Сторінка контактів
Route::view('/contacts', 'contacts')->name('contacts');
