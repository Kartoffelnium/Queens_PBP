<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nama_pelanggan',
        'jenis_room',
        'tanggal',
        'jml_orang_dewasa',
        'jml_anak_kecil',
    ];

    
}
