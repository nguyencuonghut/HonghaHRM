<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyJob extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department_id', 'division_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function proposals()
    {
        return $this->hasMany(RecruitmentProposal::class);
    }

}
