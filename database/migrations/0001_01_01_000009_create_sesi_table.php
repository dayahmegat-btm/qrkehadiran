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
        Schema::create('sesi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('acara_id');
            $table->integer('urutan_sesi');
            $table->string('tajuk_sesi', 255);
            $table->date('tarikh');
            $table->time('masa_mula');
            $table->time('masa_tamat');
            $table->string('lokasi_sesi', 500)->nullable();
            $table->decimal('jam_latihan_dikira', 4, 2);
            $table->text('qr_token_sesi')->nullable();
            $table->enum('qr_mod_sesi', ['statik', 'dinamik'])->default('statik');
            $table->boolean('adalah_wajib')->default(true);
            $table->integer('tempoh_sah_imbas_sebelum_minit')->default(30);
            $table->integer('tempoh_sah_imbas_selepas_minit')->default(30);
            $table->enum('status_sesi', ['akan_datang', 'aktif', 'selesai', 'dibatalkan'])->default('akan_datang');

            // Foreign keys
            $table->foreign('acara_id')->references('id')->on('acara')->onDelete('cascade');

            // Indexes
            $table->index(['acara_id', 'tarikh', 'status_sesi'], 'idx_sesi_lookup');
            $table->unique(['acara_id', 'urutan_sesi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi');
    }
};
