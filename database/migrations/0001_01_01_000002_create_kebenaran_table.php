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
        Schema::create('kebenaran', function (Blueprint $table) {
            $table->id();
            $table->string('kod_kebenaran', 100)->unique();
            $table->string('nama_kebenaran', 100);
            $table->string('kategori_modul', 50);
            $table->text('penerangan')->nullable();
            $table->boolean('adalah_sensitif')->default(false);

            // Indexes
            $table->index('kategori_modul');
            $table->index('adalah_sensitif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebenaran');
    }
};
