<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mdlakun extends Model
{
    use HasFactory;
    protected $table = 'users'; // Nama tabel dalam basis data
    protected $fillable = ['level','email'];
}
