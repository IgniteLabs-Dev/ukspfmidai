<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiApprovalWorkflow extends Model
{
    use HasFactory;
    protected $table = 'cuti_approval_workflow';
    protected $fillable = ['cuti_id', 'approval_level_id', 'status'];


    public function approvalLevel()
    {
        return $this->belongsTo(CutiApprovalLevel::class, 'approval_level_id');
    }
    public function cuti()
    {
        return $this->belongsTo(Cuti::class, 'cuti_id');
    }
}
