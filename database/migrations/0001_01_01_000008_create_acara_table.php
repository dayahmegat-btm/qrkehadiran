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
        Schema::create('acara', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_rujukan', 50)->unique();
            $table->string('tajuk', 500);
            $table->string('kategori', 100);
            $table->text('penerangan')->nullable();
            $table->dateTime('tarikh_mula');
            $table->dateTime('tarikh_tamat');
            $table->string('lokasi', 500)->nullable();
            $table->enum('jenis_acara', ['fizikal', 'dalam_talian', 'hibrid']);
            $table->integer('kuota')->nullable();
            $table->enum('status', ['draf', 'aktif', 'selesai', 'dibatalkan']);
            $table->uuid('dicipta_oleh');
            $table->unsignedBigInteger('jabatan_id');
            $table->text('qr_token')->nullable();
            $table->enum('qr_mod', ['statik', 'dinamik'])->default('statik');
            $table->integer('radius_geo_meter')->default(100);
            $table->decimal('koordinat_lat', 10, 8)->nullable();
            $table->decimal('koordinat_lng', 11, 8)->nullable();
            $table->enum('mod_gantian', ['tidak_dibenarkan', 'dengan_kelulusan', 'terbuka'])->default('dengan_kelulusan');
            $table->boolean('pengesahan_berterusan_aktif')->default(false);
            $table->integer('bilangan_check_in_rawak')->default(2);
            $table->decimal('ambang_kehadiran_sebahagian', 5, 2)->default(75.00);
            $table->string('pautan_meeting_url', 1000)->nullable();
            $table->boolean('adalah_berbilang_hari')->default(false);
            $table->decimal('ambang_sijil_peratus', 5, 2)->default(80.00);
            $table->enum('kategori_jam_latihan', ['kursus_wajib', 'kursus_sukarela', 'mesyuarat', 'bengkel', 'seminar', 'latihan_khusus']);
            $table->boolean('adalah_siri')->default(false);
            $table->uuid('id_acara_induk_siri')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('dicipta_oleh')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('restrict');
            $table->foreign('id_acara_induk_siri')->references('id')->on('acara')->onDelete('set null');

            // Indexes
            $table->index(['jabatan_id', 'dicipta_oleh', 'status', 'tarikh_mula', 'jenis_acara', 'adalah_berbilang_hari'], 'idx_acara_lookup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acara');
    }
};
