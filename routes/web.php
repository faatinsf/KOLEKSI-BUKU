<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\BukuUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PdfController;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;


/*
|--------------------------------------------------------------------------
| ROOT ROUTE
|--------------------------------------------------------------------------
| - Belum login  → welcome
| - Login admin  → admin dashboard
| - Login user   → user dashboard
*/


Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');
Route::get('/otp', function () {
    return view('auth.otp');
});
Route::post('/otp', function (Request $request) {
    $user = User::find(session('otp_user_id'));

    if (!$user || $user->otp !== $request->otp) {
        return back()->withErrors('OTP salah');
    }

    Auth::login($user);


    return redirect('/user/dashboard');
});


Route::get('/', function () {
    if (!auth()->check()) {
        return view('welcome');
    }

    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('buku', BukuController::class);
        Route::resource('kategori', KategoriController::class);
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'userDashboard'])
            ->name('dashboard');

        Route::resource('buku', BukuUserController::class);
        Route::resource('kategori', KategoriUserController::class);

        Route::get('/user/pdf/sertifikat', [PdfController::class, 'sertifikat'])
            ->name('pdf.sertifikat');

        Route::get('/user/pdf/undangan', [PdfController::class, 'undangan'])
            ->name('pdf.undangan');
});

/*
|--------------------------------------------------------------------------
| PROFILE ROUTES (SEMUA ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (BREEZE / JETSTREAM / UI)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
