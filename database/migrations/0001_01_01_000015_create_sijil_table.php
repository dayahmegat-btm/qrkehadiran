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
        Schema::create('sijil', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kehadiran_id');
            $table->string('url_pdf', 1000);
            $table->string('kod_pengesahan', 100)->unique();
            $table->timestamp('dijana_pada');
            $table->enum('status_kehadiran', ['penuh', 'sebahagian']);
            $table->decimal('peratus_kehadiran', 5, 2);
            $table->enum('jenis_sijil', ['peserta_penuh', 'peserta_sebahagian', 'wakil_gantian']);
            $table->json('senarai_sesi_dihadiri_json')->nullable();

            // Foreign keys
            $table->foreign('kehadiran_id')->references('id')->on('kehadiran')->onDelete('cascade');

            // Indexes
            $table->index(['kehadiran_id', 'dijana_pada'], 'idx_sijil_lookup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sijil');
    }
};
