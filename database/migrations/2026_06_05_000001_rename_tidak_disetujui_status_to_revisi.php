<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::table('laporan')
            ->where('status', 'tidak_disetujui')
            ->update(['status' => 'revisi']);
    }

    public function down()
    {
        DB::table('laporan')
            ->where('status', 'revisi')
            ->update(['status' => 'tidak_disetujui']);
    }
};
