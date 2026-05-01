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
        Schema::create('peserta_acara', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('acara_id');
            $table->uuid('pengguna_id');
            $table->enum('status_jemputan', ['dijemput', 'sah', 'tolak', 'gantian'])->default('dijemput');
            $table->enum('kategori_kehadiran', ['fizikal', 'dalam_talian'])->nullable();
            $table->string('token_pautan_unik', 255)->unique()->nullable();
            $table->dateTime('tarikh_tamat_token')->nullable();
            $table->timestamp('dicipta_pada')->useCurrent();

            // Foreign keys
            $table->foreign('acara_id')->references('id')->on('acara')->onDelete('cascade');
            $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['acara_id', 'pengguna_id', 'status_jemputan'], 'idx_peserta_lookup');
            $table->unique(['acara_id', 'pengguna_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_acara');
    }
};
