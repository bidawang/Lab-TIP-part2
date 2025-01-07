<?php

namespace App\Models;

use App\Models\mblbmn;
use App\Models\mdlalat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class mdlalatrsk extends Model
{
    use HasFactory;
    protected $table = 'alat_rusak';
    protected $primaryKey = 'id_alat_rusak';
    protected $fillable = [
        'id_alat',
        'penanggungjawab',
        'penyebab_kerusakan',
        'keterangan',
        'tingkat_kerusakan',
        'google_id',
        'jumlah',
        'id_bmn',
        'kode_barang',
    'riwayat'];
    public function alat()
    {
        return $this->belongsTo(mdlalat::class, 'id_alat');
    }
    public function alat_bmn()
    {
        return $this->belongsTo(mblbmn::class, 'id_bmn');
    }
    
}
