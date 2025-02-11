<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mdlbeli extends Model
{
    use HasFactory;
    protected $table = 'pembelian'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_pembelian';
    protected $fillable = [
        'nama_barang',
        'harga',
        'jenis',
        'satuan',
        'foto_pembelian',
        'nama_toko',
        'jumlah',
        'keterangan',
        'google_id'
    ];

}
