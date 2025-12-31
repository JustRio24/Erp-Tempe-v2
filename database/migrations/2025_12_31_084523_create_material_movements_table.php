<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('material_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->decimal('jumlah', 12, 2);
            $table->string('referensi_tipe')->nullable(); // pembelian, produksi, penyesuaian
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_movements');
    }
};
