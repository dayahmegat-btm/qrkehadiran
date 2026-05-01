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
        Schema::create('audit_log', function (Blueprint $table) {
            $table->id();
            $table->uuid('pengguna_id')->nullable();
            $table->string('tindakan', 100);
            $table->string('jenis_objek', 50);
            $table->string('id_objek', 255)->nullable();
            $table->json('butiran_json')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamp('masa');

            // Foreign keys
            $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index(['pengguna_id', 'tindakan', 'jenis_objek', 'masa'], 'idx_audit_lookup');
            $table->index(['jenis_objek', 'id_objek'], 'idx_audit_object');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};
