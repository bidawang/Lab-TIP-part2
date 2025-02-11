<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mdlbahan extends Model
{
    use HasFactory;
    protected $table = 'bahan'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_bahan';
    protected $fillable = [
        'nama_bahan',
        'stok',
        'satuan',
        'foto_bahan',
        'id_pembelian',
        'keterangan',
        'google_id'
    ];
}
