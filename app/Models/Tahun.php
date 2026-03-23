<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;
    protected $table = 'tahun';
    protected $fillable = ['tahun','status'];

 
    public function cuti()
    {
        return $this->hasMany(Cuti::class);
    }
}
