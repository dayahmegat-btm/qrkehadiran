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
        Schema::create('pengesahan_berterusan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kehadiran_sesi_id');
            $table->timestamp('masa_dijadual');
            $table->timestamp('masa_dipaparkan')->nullable();
            $table->timestamp('masa_dijawab')->nullable();
            $table->enum('status', ['dijawab', 'terlepas', 'belum_dipaparkan'])->default('belum_dipaparkan');

            // Foreign keys
            $table->foreign('kehadiran_sesi_id')->references('id')->on('kehadiran_sesi')->onDelete('cascade');

            // Indexes
            $table->index(['kehadiran_sesi_id', 'masa_dijadual', 'status'], 'idx_pengesahan_lookup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengesahan_berterusan');
    }
};
