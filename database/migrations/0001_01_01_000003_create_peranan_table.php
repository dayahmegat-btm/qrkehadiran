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
        Schema::create('peranan', function (Blueprint $table) {
            $table->id();
            $table->string('kod_peranan', 50)->unique();
            $table->string('nama_peranan', 100);
            $table->text('penerangan')->nullable();
            $table->boolean('adalah_lalai_sistem')->default(false);
            $table->boolean('boleh_dipadam')->default(true);
            $table->integer('tahap_hierarki');
            $table->uuid('dicipta_oleh')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('dicipta_oleh')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('tahap_hierarki');
            $table->index('adalah_lalai_sistem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peranan');
    }
};
