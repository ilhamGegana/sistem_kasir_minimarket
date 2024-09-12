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
        Schema::create('members', function (Blueprint $table) {
            $table->id('member_id');
            $table->string('nomor_member', 20)->unique();
            $table->string('nama_member', 100);
            $table->string('no_telepon', 15)->nullable();
            $table->date('tanggal_daftar');
            $table->date('tanggal_expired')->nullable();
            $table->enum('status', ['aktif', 'non-aktif']);
            $table->timestamps(); // automatically adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
