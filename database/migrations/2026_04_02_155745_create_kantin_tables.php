<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel vendor (bisa login sebagai role 'vendor')
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_vendor');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel menu milik vendor
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->string('nama_menu');
            $table->integer('harga');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Tabel guest user (customer tanpa login)
        Schema::create('guest_users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guest')->unique(); // format: Guest_0000001
            $table->timestamps();
        });

        // Tabel orders (pesanan dari customer)
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_user_id')->constrained('guest_users')->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->integer('total');
            $table->enum('status_pembayaran', ['pending', 'lunas'])->default('pending');
            $table->timestamps();
        });

        // Tabel detail pesanan
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();
        });

        // Tabel payments (data dari Midtrans)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('snap_token')->nullable();
            $table->string('transaction_id')->nullable(); // dari Midtrans
            $table->string('payment_type')->nullable();   // va / qris
            $table->enum('status', ['pending', 'settlement', 'cancel', 'expire'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('guest_users');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('vendors');
    }
};