<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->decimal('harga_beli_terakhir', 15, 2)->default(0)->after('stok_minimal');
            $table->string('satuan_beli')->nullable()->after('harga_beli_terakhir');
            $table->decimal('rasio_konversi', 10, 2)->default(1)->after('satuan_beli');
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['harga_beli_terakhir', 'satuan_beli', 'rasio_konversi']);
        });
    }
};
