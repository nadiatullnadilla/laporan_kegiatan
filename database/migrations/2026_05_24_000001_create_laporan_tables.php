<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('role', 20)->default('admin');
        });

        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('tempat', 100);
            $table->string('jam', 20);
            $table->string('dokumen')->nullable();
            $table->string('nama_kegiatan');
            $table->text('deskripsi_kegiatan')->nullable();
            $table->string('status', 30)->default('menunggu');
            $table->text('catatan_verifikator')->nullable();
        });

        Schema::create('file_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan')->cascadeOnDelete();
            $table->string('nama_file');
        });

        Schema::create('riwayat_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('aktivitas');
            $table->dateTime('waktu')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_aktivitas');
        Schema::dropIfExists('file_laporan');
        Schema::dropIfExists('laporan');
        Schema::dropIfExists('user');
    }
};
