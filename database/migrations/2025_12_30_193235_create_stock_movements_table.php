<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->string('referensi_tipe')->nullable(); // 'produksi', 'penjualan', 'penyesuaian'
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index('product_id');
            $table->index('tipe');
            $table->index(['referensi_tipe', 'referensi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
