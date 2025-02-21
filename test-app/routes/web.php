<?php

use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplianceController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/addAppliance', [ApplianceController::class, 'show'])->name('addAppliance');
    Route::get('/storage', [ApplianceController::class, 'showStorage'])->name('storage');
    Route::post('/equipments', [ApplianceController::class, 'storeEquipment'])->name('equipment.store');
    Route::post('/equipment-types', [ApplianceController::class, 'storeEquipmentType'])->name('equipmentType.store');

});

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin', [AdminRegisterController::class, 'index'])->name('admin.dashboard');
    Route::get('/register-user', [AdminRegisterController::class, 'create'])->name('register-user');
});




require __DIR__.'/auth.php';
