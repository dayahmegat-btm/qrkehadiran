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
        Schema::create('pengguna_peranan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengguna_id');
            $table->unsignedBigInteger('peranan_id');
            $table->enum('skop_jenis', ['semua_negeri', 'jabatan_tertentu', 'sendiri']);
            $table->unsignedBigInteger('skop_jabatan_id')->nullable();
            $table->date('tarikh_mula');
            $table->date('tarikh_tamat')->nullable();
            $table->enum('status', ['aktif', 'dicabut', 'tamat_tempoh'])->default('aktif');
            $table->boolean('adalah_pemangku')->default(false);
            $table->string('rujukan_surat_pelantikan', 255)->nullable();
            $table->uuid('dilantik_oleh')->nullable();
            $table->timestamp('dilantik_pada')->nullable();
            $table->text('sebab_pencabutan')->nullable();

            // Foreign keys
            $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('peranan_id')->references('id')->on('peranan')->onDelete('restrict');
            $table->foreign('skop_jabatan_id')->references('id')->on('jabatan')->onDelete('restrict');
            $table->foreign('dilantik_oleh')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index(['pengguna_id', 'peranan_id', 'status', 'tarikh_tamat', 'skop_jabatan_id'], 'idx_pengguna_peranan_composite');
            $table->index(['pengguna_id', 'status'], 'idx_pengguna_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna_peranan');
    }
};
