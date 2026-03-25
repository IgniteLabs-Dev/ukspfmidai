<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiApprovalLevel extends Model
{
  use HasFactory;
  protected $table = 'cuti_approval_level_ref';
  protected $fillable = ['jabatan_id'];

  public function jabatan()
  {
    return $this->belongsTo(Jabatan::class, 'jabatan_id');
  }

  public function cutiApprovals()
  {
    return $this->hasMany(CutiApprovalWorkflow::class, 'approval_level_id');
  }
}
