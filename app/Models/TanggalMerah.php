<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalMerah extends Model
{
    use HasFactory;
    protected $table = 'tanggal_merah';
    protected $fillable = ['tanggal', 'keterangan', 'status'];
}
