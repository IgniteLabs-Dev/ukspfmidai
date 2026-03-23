<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $table = 'cuti';
    protected $fillable = [
        'user_id',
        'cuti_type_id',
        'tanggal_acc',
        'alasan',
        'status',
        'tanggal',
        'kuota_used',
        'total_hari',
    ];

    public function cutiType()
    {
        return $this->belongsTo(CutiType::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cutiApprovalWorkflows()
    {
        return $this->hasMany(CutiApprovalWorkflow::class);
    }
}
