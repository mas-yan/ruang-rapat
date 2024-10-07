<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/list-book', function () {
//     return view('list-book');
// })->middleware(['auth', 'verified'])->name('list-book');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/ruangan', RuanganController::class)->except('index')->middleware('role:admin');
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::resource('/list-book', BookingController::class);
});

require __DIR__ . '/auth.php';
