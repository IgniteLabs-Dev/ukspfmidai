<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan';
    protected $fillable = ['name', 'status'];

    public function user()
    {
        return $this->hasMany(User::class, 'jabatan_id');
    }

    public function approval_level()
    {
        return $this->hasMany(CutiApprovalLevel::class, 'jabatan_id');
    }
}
