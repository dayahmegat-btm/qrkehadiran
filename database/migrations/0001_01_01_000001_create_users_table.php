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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_kp', 12)->unique();
            $table->string('no_pekerja', 50)->unique()->nullable();
            $table->string('nama');
            $table->string('emel')->unique();
            $table->string('no_telefon', 20)->nullable();
            $table->string('kata_laluan_hash');
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->string('jawatan', 100)->nullable();
            $table->string('gred', 20)->nullable();
            $table->string('peranan', 50)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->boolean('epsm_verified')->default(false);
            $table->timestamp('epsm_last_synced_at')->nullable();
            $table->json('epsm_raw_data')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Foreign keys
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('set null');

            // Indexes
            $table->index('jabatan_id');
            $table->index('status_aktif');
            $table->index('epsm_verified');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
