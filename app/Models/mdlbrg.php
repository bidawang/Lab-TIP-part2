<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mdlbrg extends Model
{
    use HasFactory;
    protected $table= 'barang';
    protected $primaryKey='id_barang';
    protected $fillable = [
        'nama_barang',
        'foto_barang',
        'keterangan',
        'google_id',
        'kode_barang', // Jika Anda ingin memasukkan kode_barang secara manual
    ];
}
