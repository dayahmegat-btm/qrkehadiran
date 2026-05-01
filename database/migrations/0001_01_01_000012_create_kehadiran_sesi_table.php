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
        Schema::create('kehadiran_sesi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sesi_id');
            $table->uuid('pengguna_id');
            $table->uuid('peserta_acara_id');
            $table->timestamp('masa_daftar_masuk');
            $table->timestamp('masa_daftar_keluar')->nullable();
            $table->decimal('koordinat_imbas_lat', 10, 8)->nullable();
            $table->decimal('koordinat_imbas_lng', 11, 8)->nullable();
            $table->string('alat_imbas', 255)->nullable();
            $table->string('ip_imbas', 45)->nullable();
            $table->boolean('status_sah')->default(true);
            $table->enum('kaedah_kehadiran', ['qr_fizikal', 'qr_skrin', 'pautan_unik', 'pengesahan_berterusan', 'api_meeting']);
            $table->boolean('adalah_wakil_gantian')->default(false);
            $table->uuid('id_peserta_asal')->nullable();
            $table->decimal('jam_latihan_dikreditkan', 4, 2);
            $table->decimal('peratus_pengesahan', 5, 2)->default(100.00);

            // Foreign keys
            $table->foreign('sesi_id')->references('id')->on('sesi')->onDelete('cascade');
            $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('peserta_acara_id')->references('id')->on('peserta_acara')->onDelete('cascade');
            $table->foreign('id_peserta_asal')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index(['sesi_id', 'pengguna_id', 'masa_daftar_masuk', 'adalah_wakil_gantian'], 'idx_kehadiran_sesi_lookup');
            $table->unique(['sesi_id', 'pengguna_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran_sesi');
    }
};
