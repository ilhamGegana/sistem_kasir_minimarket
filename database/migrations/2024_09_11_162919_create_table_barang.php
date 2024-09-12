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
        Schema::create('barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->string('kode_barang', 20)->unique();
            $table->string('nama_barang', 100);
            $table->foreignId('kategori_id')->constrained('kategori_barang', 'kategori_id')->onDelete('restrict')->onUpdate('cascade');
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            $table->timestamps(); // automatically adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
