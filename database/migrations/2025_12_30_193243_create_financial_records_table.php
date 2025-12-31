<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->string('kategori'); // e.g., 'Penjualan', 'Bahan Baku', 'Operasional'
            $table->decimal('jumlah', 12, 2);
            $table->text('deskripsi')->nullable();
            $table->string('referensi_tipe')->nullable(); // 'order', 'manual'
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->timestamps();
            
            $table->index('tanggal');
            $table->index('tipe');
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};
