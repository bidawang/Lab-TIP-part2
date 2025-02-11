<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mblbmn extends Model
{
    use HasFactory;

    // Define the table name if it's different from the pluralized form of the model name
    protected $table = 'alat_bmn';
    protected $primaryKey = 'id_bmn';

    // Define the fillable fields
    protected $fillable = [
        'nama_alat',
        'merk',
        'kode_barang',
        'kondisi_barang',
        'foto_barang',
        'foto_kode',
        'keterangan',
        'stok',
        'satuan',
        'google_id'
    ];

    public function rusak()
    {
        return $this->hasMany(AlatRusak::class, 'id_bmn', 'id_bmn');
    }
}
