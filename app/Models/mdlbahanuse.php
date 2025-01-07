<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mdlbahanuse extends Model
{
    use HasFactory;
    protected $table = 'bahan_pakai'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_bahan_pakai';
    protected $fillable = [
        'nama_bahan',
        'jumlah',
        'satuan',
        'keperluan',
        'nama_pemakai',
        'tanggal_pemakaian',
        'google_id',
        'status'
    ];
    public function bahan()
{
    return $this->belongsTo('App\Models\mdlbahan', 'nama_bahan', 'nama_bahan');
}
}