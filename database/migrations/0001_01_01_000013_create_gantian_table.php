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
        Schema::create('gantian', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('acara_id');
            $table->uuid('sesi_id')->nullable();
            $table->uuid('peserta_asal_id');
            $table->uuid('wakil_id');
            $table->text('alasan');
            $table->enum('jenis_gantian', ['pra_acara', 'walk_in', 'auto_terbuka', 'per_sesi']);
            $table->enum('status', ['menunggu', 'diluluskan', 'ditolak'])->default('menunggu');
            $table->uuid('penyelaras_lulus_id')->nullable();
            $table->timestamp('masa_permohonan');
            $table->timestamp('masa_keputusan')->nullable();
            $table->text('ulasan_penyelaras')->nullable();

            // Foreign keys
            $table->foreign('acara_id')->references('id')->on('acara')->onDelete('cascade');
            $table->foreign('sesi_id')->references('id')->on('sesi')->onDelete('cascade');
            $table->foreign('peserta_asal_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wakil_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('penyelaras_lulus_id')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index(['acara_id', 'sesi_id', 'peserta_asal_id', 'wakil_id', 'status'], 'idx_gantian_lookup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gantian');
    }
};
