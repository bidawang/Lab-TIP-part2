<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mdlalatpjm extends Model
{
    use HasFactory;
    protected $table = 'alat_pinjam'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_alat_pinjam';
    protected $fillable = [
        'nama_peminjam',
        'nama_alat',
        'jumlah',
        'satuan',
        'tempat_peminjaman',
        'tanggal_peminjaman',
        'tanggal_kembali',
        'keperluan',
        'google_id',
        'status'
    ];
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_akhir' => 'datetime',
        // other casts...
    ];
    public function alat()
{
    return $this->belongsTo('App\Models\mdlalat', 'nama_alat', 'nama_alat');
}
}
