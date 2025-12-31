<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batch_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('jumlah');
            $table->timestamps();
            
            $table->index(['production_batch_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_products');
    }
};
