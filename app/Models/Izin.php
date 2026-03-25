<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $table = 'izin';
    protected $fillable = [
        'user_id',
        'tanggal_acc',
        'izin_type_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keperluan',
        'status',
        'doc',
    ];

    public function izinType()
    {
        return $this->belongsTo(IzinType::class);
    }
        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
