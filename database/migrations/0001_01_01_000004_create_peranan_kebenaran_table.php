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
        Schema::create('peranan_kebenaran', function (Blueprint $table) {
            $table->unsignedBigInteger('peranan_id');
            $table->unsignedBigInteger('kebenaran_id');
            $table->timestamps();

            // Primary key (composite)
            $table->primary(['peranan_id', 'kebenaran_id']);

            // Foreign keys
            $table->foreign('peranan_id')->references('id')->on('peranan')->onDelete('cascade');
            $table->foreign('kebenaran_id')->references('id')->on('kebenaran')->onDelete('cascade');

            // Indexes
            $table->index('kebenaran_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peranan_kebenaran');
    }
};
