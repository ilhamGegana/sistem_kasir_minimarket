<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('transaksi_id');  // Primary key
            $table->foreignId('pengguna_id')->constrained('pengguna','pengguna_id')->onDelete('restrict')->onUpdate('cascade');  // Foreign key to pengguna
            $table->foreignId('member_id')->nullable()->constrained('members', 'member_id')->onDelete('set null')->onUpdate('cascade');  // Foreign key to members (nullable)
            $table->dateTime('tanggal')->default(DB::raw('CURRENT_TIMESTAMP'));  // Transaction date
            $table->decimal('total_harga', 10, 2);  // Total transaction amount
            $table->enum('metode_pembayaran', ['cash', 'card']);  // Payment method: cash or card
            $table->timestamps();  // Automatically adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
