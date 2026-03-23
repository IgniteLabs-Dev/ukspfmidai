<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinApprovalWorkflow extends Model
{
    use HasFactory;
    protected $table = 'izin_approval_workflow';
    protected $fillable = ['izin_id', 'approval_level_id', 'status'];

    public function approvalLevel()
    {
        return $this->belongsTo(IzinApprovalLevel::class, 'approval_level_id');
    }
    public function izin()
    {
        return $this->belongsTo(Izin::class, 'izin_id');
    }
}
