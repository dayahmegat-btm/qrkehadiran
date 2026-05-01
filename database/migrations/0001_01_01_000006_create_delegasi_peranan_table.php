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
        Schema::create('delegasi_peranan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pemberi_id');
            $table->uuid('penerima_id');
            $table->unsignedBigInteger('peranan_id');
            $table->json('kebenaran_terpilih_json')->nullable();
            $table->date('tarikh_mula');
            $table->date('tarikh_tamat');
            $table->text('alasan');
            $table->enum('status', ['menunggu', 'diluluskan', 'ditolak', 'aktif', 'tamat_tempoh', 'dibatalkan'])->default('menunggu');
            $table->uuid('penerima_kelulusan_id')->nullable();
            $table->timestamp('masa_kelulusan')->nullable();
            $table->text('ulasan')->nullable();

            // Foreign keys
            $table->foreign('pemberi_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('penerima_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('peranan_id')->references('id')->on('peranan')->onDelete('restrict');
            $table->foreign('penerima_kelulusan_id')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index(['pemberi_id', 'penerima_id', 'peranan_id', 'status', 'tarikh_tamat'], 'idx_delegasi_composite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegasi_peranan');
    }
};
