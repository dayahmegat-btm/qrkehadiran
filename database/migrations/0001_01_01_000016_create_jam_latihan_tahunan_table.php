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
        Schema::create('jam_latihan_tahunan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengguna_id');
            $table->integer('tahun');
            $table->decimal('jumlah_jam', 6, 2)->default(0);
            $table->decimal('jam_kursus_wajib', 6, 2)->default(0);
            $table->decimal('jam_kursus_sukarela', 6, 2)->default(0);
            $table->decimal('jam_mesyuarat', 6, 2)->default(0);
            $table->decimal('jam_bengkel', 6, 2)->default(0);
            $table->decimal('jam_seminar', 6, 2)->default(0);
            $table->decimal('jam_latihan_khusus', 6, 2)->default(0);
            $table->decimal('sasaran_jam', 5, 2)->default(56.00);
            $table->decimal('peratus_pencapaian', 5, 2)->default(0);
            $table->timestamp('dikemaskini_pada')->nullable();

            // Foreign keys
            $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['pengguna_id', 'tahun'], 'idx_jam_latihan_lookup');
            $table->unique(['pengguna_id', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_latihan_tahunan');
    }
};
