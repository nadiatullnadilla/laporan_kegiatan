<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('riwayat_aktivitas');
    }

    public function down()
    {
        Schema::create('riwayat_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('aktivitas');
            $table->dateTime('waktu')->useCurrent();
        });
    }
};
