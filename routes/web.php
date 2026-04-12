<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangUserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\BukuUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriUserController;
use App\Http\Controllers\ModulBarangController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PdfController;
use App\Http\Controllers\WilayahController;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;
// ============================================================
// TAMBAHKAN import ini di bagian atas web.php (setelah use yang sudah ada)
// ============================================================
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Vendor\VendorMenuController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\QrCodeController;


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
        Route::get('/modulbarang', [ModulBarangController::class, 'index'])
                  ->name('modulbarang.index');

        Route::get('/modulbarang/halaman2', [ModulBarangController::class, 'halamanDua'])
            ->name('modulbarang.halaman2');
        
        Route::get('/modulbarang/halaman3', [ModulBarangController::class, 'halamanTiga'])
            ->name('modulbarang.halaman3');
            
        Route::resource('barang', BarangController::class);
        
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
        
        Route::resource('barang', BarangUserController::class)
            ->only(['index']);

        // nanti buat TNJ PDF di sini
        Route::post('/barang/cetak', [BarangUserController::class, 'cetak'])
            ->name('barang.cetak');

        Route::get('/barang/pilih', [BarangUserController::class, 'pilih'])
            ->name('barang.pilih');

        Route::post('/barang/proses', [BarangUserController::class, 'proses'])
            ->name('barang.proses');
        // Customer routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/tambah1', [CustomerController::class, 'tambah1'])->name('tambah1');
    Route::post('/simpan1', [CustomerController::class, 'simpan1'])->name('simpan1');
    Route::get('/tambah2', [CustomerController::class, 'tambah2'])->name('tambah2');
    Route::post('/simpan2', [CustomerController::class, 'simpan2'])->name('simpan2');
});

// QR Code route
Route::get('/qrcode', [QrCodeController::class, 'index'])->name('qrcode.index');
Route::get('/qrcode/generate', [QrCodeController::class, 'generate'])->name('qrcode.generate');

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


Route::prefix('ajax-axios')->group(function () {

    Route::get('/case1/ajax', [WilayahController::class,'ajaxIndex'])
        ->name('case1.ajax');

    Route::get('/case1/axios', [WilayahController::class,'axiosIndex'])
        ->name('case1.axios');

});

Route::prefix('wilayah')->group(function () {

    Route::get('/provinsi', [WilayahController::class,'getProvinsi']);
    Route::get('/kota/{id}', [WilayahController::class,'getKota']);
    Route::get('/kecamatan/{id}', [WilayahController::class,'getKecamatan']);
    Route::get('/kelurahan/{id}', [WilayahController::class,'getKelurahan']);

});



Route::prefix('ajax-axios')->group(function () {

    Route::get('/case2/ajax', [POSController::class,'ajaxIndex'])->name('case2.ajax');

    Route::get('/case2/axios', [POSController::class,'axiosIndex'])->name('case2.axios');

});

Route::get('/barang/{kode}', [POSController::class,'getBarang']);

Route::post('/transaksi/simpan', [POSController::class,'simpanTransaksi']);





// ============================================================
// VENDOR ROUTES — tambahkan setelah block USER ROUTES
// ============================================================
Route::middleware(['auth', 'role:vendor'])
    ->prefix('vendor')
    ->name('vendor.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('vendor.dashboard');
        })->name('dashboard');

        // Master Menu
        Route::resource('menu', VendorMenuController::class);

        // Pesanan Lunas
        Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
    });

// ============================================================
// CUSTOMER ROUTES — publik, tanpa login
// ============================================================
Route::prefix('kantin')->name('kantin.')->group(function () {

    // Halaman pemesanan utama
    Route::get('/', [CustomerOrderController::class, 'index'])->name('order');

    // AJAX: ambil menu by vendor
    Route::get('/menu/{vendorId}', [CustomerOrderController::class, 'getMenuByVendor'])->name('menu.byVendor');

    // Proses checkout → dapat snap_token
    Route::post('/checkout', [CustomerOrderController::class, 'checkout'])->name('checkout');

    // Halaman sukses
    Route::get('/sukses/{orderId}', [CustomerOrderController::class, 'sukses'])->name('sukses');
});

// ============================================================
// MIDTRANS WEBHOOK — harus dikecualikan dari CSRF
// Tambahkan 'kantin/webhook/midtrans' ke $except di VerifyCsrfToken.php
// ============================================================
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle'])
    ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (BREEZE / JETSTREAM / UI)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
