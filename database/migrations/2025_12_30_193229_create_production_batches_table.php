<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_batches', function (Blueprint $table) {
            $table->id();
            $table->string('kode_batch')->unique();
            $table->date('tanggal_mulai');
            $table->integer('hari_ke')->default(1); // 1-4
            $table->enum('status', ['Hari ke-1', 'Hari ke-2', 'Hari ke-3', 'Siap dijual', 'Selesai'])->default('Hari ke-1');
            $table->integer('jumlah_target')->default(0);
            $table->integer('jumlah_jadi')->default(0);
            $table->integer('jumlah_gagal')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('tanggal_mulai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_batches');
    }
};
