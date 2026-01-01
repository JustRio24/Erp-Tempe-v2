<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pesanan')->unique(); // Nanti digenerate di Model
            
            $table->string('nama_pembeli');
            $table->string('email_pembeli');
            $table->string('telepon_pembeli');
            $table->text('alamat_pembeli');
            
            // TETAP 'transfer_bank'
            $table->enum('metode_pembayaran', ['transfer_bank', 'cod'])->default('cod');
            
            $table->string('bank_tujuan')->nullable(); 
            $table->enum('metode_pengiriman', ['ambil_sendiri', 'kurir'])->default('ambil_sendiri');
            
            $table->integer('total_item')->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('ongkir', 10, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            
            // Tambahkan kolom ini untuk Midtrans
            $table->string('snap_token')->nullable(); 
            
            $table->enum('status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            
            $table->timestamps();
            
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};