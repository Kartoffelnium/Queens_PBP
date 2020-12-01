<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'jenis_kamar',
        'harga_kamar',
        'layanan',
        'image_kamar',
    ];


}
