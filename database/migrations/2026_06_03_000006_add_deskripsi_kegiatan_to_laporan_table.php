<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('laporan', 'deskripsi_kegiatan')) {
            Schema::table('laporan', function (Blueprint $table) {
                $table->text('deskripsi_kegiatan')->nullable()->after('nama_kegiatan');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('laporan', 'deskripsi_kegiatan')) {
            Schema::table('laporan', function (Blueprint $table) {
                $table->dropColumn('deskripsi_kegiatan');
            });
        }
    }
};
