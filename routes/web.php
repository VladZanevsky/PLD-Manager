<?php

use App\Http\Controllers\Admin\AnimalPetController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FpgaComponentController;
use App\Http\Controllers\Admin\ManufacturerController;
use App\Http\Controllers\Admin\StandardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FpgaSelectionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\SuperAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');
Route::post('/select', [FpgaSelectionController::class, 'select'])->name('fpga.select');
Route::post('/compare', [FpgaSelectionController::class, 'compare'])->name('fpga.compare');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/export-pdf', [FpgaSelectionController::class, 'exportPdf'])->name('export.pdf');
});

// Админская панель
Route::prefix('/admin')->name('admin.')->middleware('auth')->group(function () {
    Route::middleware(SuperAdminMiddleware::class)->group(function () {
        Route::get('/', [AuthController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
        Route::resource('manufacturers', ManufacturerController::class);
        Route::resource('standards', StandardController::class);
        Route::resource('fpga-components', FpgaComponentController::class);
        Route::resource('animal-pets', AnimalPetController::class);
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/change-password', 'changePassword')->name('change-password');
        Route::post('/change-password', 'passwordStore')->name('change-password.store');
    });
});


require __DIR__.'/auth.php';
