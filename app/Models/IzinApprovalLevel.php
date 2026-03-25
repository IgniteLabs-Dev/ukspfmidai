<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinApprovalLevel extends Model
{
    use HasFactory;
    protected $table = 'izin_approval_level_ref';
    protected $fillable = ['jabatan_id'];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function izinApprovals()
    {
        return $this->hasMany(IzinApprovalWorkflow::class, 'approval_level_id');
    }
}
