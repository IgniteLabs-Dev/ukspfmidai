<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinType extends Model
{
     use HasFactory;
    protected $table = 'izin_type';
    protected $fillable = [
        'name',
        'status',
    ];

    public function izin()
    {
        return $this->hasMany(Izin::class);
    }
}
