<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('buku', BukuController::class);
        Route::resource('kategori', KategoriController::class);
});

Route::middleware(['auth','role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');

        Route::resource('buku', BukuUserController::class);
        Route::resource('kategori', KategoriUserController::class);
});
       Route::middleware(['auth','role:user'])->group(function () {
         Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])
              ->name('user.dashboard'); 
        });


Route::get('/', function () {
    if (!auth()->check()) {
        return view('welcome');
    }

    return auth()->admin()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
