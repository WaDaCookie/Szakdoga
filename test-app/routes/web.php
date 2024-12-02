<?php

use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin', [AdminRegisterController::class, 'index'])->name('admin.dashboard');
    Route::get('/register-user', [AdminRegisterController::class, 'create'])->name('register-user');
});




require __DIR__.'/auth.php';
