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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('transaksi_id')->constrained('transaksi','transaksi_id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('barang_id')->constrained('barang', 'barang_id')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('jumlah');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps(); // automatically adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
