<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mdlruang extends Model
{
    use HasFactory;
    protected $table = 'ruangan'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_alat';
    protected $fillable = [
        'nama_ruangan',
        'lantai',
        'gedung',
        'laboran',
        'foto_ruangan'
    ];

}
