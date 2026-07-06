<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileLaporan extends Model
{
    protected $table = 'file_laporan';

    public $timestamps = false;

    protected $fillable = [
        'laporan_id',
        'nama_file',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }
}
