<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE laporan MODIFY dokumen VARCHAR(255) NULL');
    }

    public function down()
    {
        DB::statement("UPDATE laporan SET dokumen = '' WHERE dokumen IS NULL");
        DB::statement("ALTER TABLE laporan MODIFY dokumen VARCHAR(255) NOT NULL DEFAULT ''");
    }
};
