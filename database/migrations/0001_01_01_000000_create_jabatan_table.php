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
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('kod_jabatan', 20)->unique();
            $table->string('nama_jabatan');
            $table->unsignedBigInteger('ptj_induk')->nullable();
            $table->text('alamat')->nullable();
            $table->string('logo_url', 500)->nullable();

            // Foreign key for self-referencing
            $table->foreign('ptj_induk')->references('id')->on('jabatan')->onDelete('set null');

            // Indexes
            $table->index('ptj_induk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
