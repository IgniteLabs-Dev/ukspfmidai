<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiType extends Model
{
    use HasFactory;
    protected $table = 'cuti_type';
    protected $fillable = ['name', 'status', 'deskripsi', 'is_count'];

    public function cuti()
    {
        return $this->hasMany(Cuti::class);
    }
}
