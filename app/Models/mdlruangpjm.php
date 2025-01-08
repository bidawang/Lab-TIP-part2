<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mdlruangpjm extends Model
{
    use HasFactory;
    protected $table = 'pinjam_ruangan'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_pinjam_ruangan';

    protected $fillable = [
        'keperluan',
        'tanggal_peminjaman',
        'jam_mulai',
        'jam_selesai',
        'mata_kuliah',
        'status',
        'nama_ruangan',
        'google_id',
        'tipe_peminjaman',
        'created_by'
    ];
}
