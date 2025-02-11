<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mdlalat extends Model
{
    use HasFactory;
    protected $table = 'alat'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_alat';
    protected $fillable = [
        'nama_alat',
        'stok',
        'satuan',
        'foto_alat',
        'id_pembelian',
        'keterangan',
        'google_id'
    ];

    public function rusak()
    {
        return $this->hasMany(AlatRusak::class, 'id_alat', 'id_alat');
    }

}
