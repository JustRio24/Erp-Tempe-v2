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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('satuan', ['kg', 'pcs', 'papan'])->default('pcs');
            $table->decimal('harga_normal', 10, 2);
            $table->decimal('harga_grosir', 10, 2)->nullable();
            $table->integer('minimal_grosir')->nullable();
            $table->integer('stok_tersedia')->default(0);
            $table->integer('batas_kadaluarsa_hari')->default(5); // Default 5 days for tempe
            $table->string('gambar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('is_active');
            $table->index('stok_tersedia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
