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
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('acara_id');
            $table->uuid('pengguna_id');
            $table->integer('jumlah_sesi_wajib');
            $table->integer('sesi_wajib_dihadiri');
            $table->decimal('peratus_kehadiran_dikira', 5, 2);
            $table->decimal('jumlah_jam_latihan_acara', 5, 2);
            $table->enum('status_kelayakan_sijil', ['penuh', 'sebahagian', 'tidak_layak']);
            $table->timestamp('tarikh_dikira')->nullable();

            // Foreign keys
            $table->foreign('acara_id')->references('id')->on('acara')->onDelete('cascade');
            $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['acara_id', 'pengguna_id', 'status_kelayakan_sijil'], 'idx_kehadiran_lookup');
            $table->unique(['acara_id', 'pengguna_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
