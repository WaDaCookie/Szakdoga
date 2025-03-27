<?php

use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplianceController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\RoomController;
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
    Route::get('/updateAppliance', [ApplianceController::class, 'update'])->name('updateAppliance');
    Route::get('/appliance/{id}/edit', [ApplianceController::class, 'edit']);
    Route::put('/appliance/{id}', [ApplianceController::class, 'updateAppliance'])->name('appliance.update');
//    Route::get('/appliance/search', [ApplianceController::class, 'searchAppliance'])->name('appliance.search');
    Route::put('/appliance/{id}', [ApplianceController::class, 'updateEquipment'])->name('appliance.update');
    Route::get('/appliance/by-type/{equipmentTypeId}', [ApplianceController::class, 'getApplianceByType']);
    Route::get('/equipment-type/search', [ApplianceController::class, 'searchEquipmentTypes']);
    Route::put('/equipment-type/{id}', [ApplianceController::class, 'updateApplianceStatus']);
    Route::get('/storage', [ApplianceController::class, 'showStorage'])->name('storage');
    Route::post('/equipments', [ApplianceController::class, 'storeEquipment'])->name('equipment.store');
    Route::post('/equipment-types', [ApplianceController::class, 'storeEquipmentType'])->name('equipmentType.store');
    Route::get('/view/room/{room}', [RoomController::class, 'viewRoom'])->name('view-room');
    Route::put('/room/{room}/update-equipments', [RoomController::class, 'updateRoomEquipments'])->name('update-room-equipments');

    Route::delete('/equipment/{equipment}', [ApplianceController::class, 'destroy'])->name('equipment.destroy');

    Route::get('/qrcode/{type_id}', [QRController::class, 'generate'])->name('qrcode.generate');
    Route::get('/qrcode/read/{qrcode}', [QRController::class, 'open'])->name('qrcode.read');

});

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin', [AdminRegisterController::class, 'index'])->name('admin.dashboard');
    Route::get('/register-user', [AdminRegisterController::class, 'create'])->name('register-user');
    Route::post('/store-user', [AdminRegisterController::class, 'store'])->name('store-user');
});




require __DIR__.'/auth.php';
