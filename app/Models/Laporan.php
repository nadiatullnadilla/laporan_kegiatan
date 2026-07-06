<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    public $timestamps = false;

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'tempat',
        'jam',
        'dokumen',
        'status',
        'catatan_verifikator',
    ];

    public function files()
    {
        return $this->hasMany(FileLaporan::class, 'laporan_id');
    }
}
