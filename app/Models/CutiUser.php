<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiUser extends Model
{
    use HasFactory;

    protected $table = 'cuti_user';
    protected $fillable = ['cuti_type_id', 'user_id', 'kuota', 'tahun', 'cuti_tersimpan'];

    public function cuti()
    {
        return $this->belongsTo(CutiType::class, 'cuti_type_id');
    }
}
