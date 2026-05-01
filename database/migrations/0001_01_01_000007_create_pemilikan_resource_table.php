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
        Schema::create('pemilikan_resource', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengguna_id');
            $table->enum('jenis_resource', ['event', 'session', 'report']);
            $table->uuid('resource_id');
            $table->enum('jenis_pemilikan', ['pencipta', 'penyelaras', 'pengerusi']);
            $table->timestamp('dicipta_pada')->useCurrent();

            // Foreign keys
            $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['pengguna_id', 'jenis_resource', 'resource_id'], 'idx_pemilikan_lookup');
            $table->unique(['pengguna_id', 'jenis_resource', 'resource_id', 'jenis_pemilikan'], 'unique_resource_ownership');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilikan_resource');
    }
};
