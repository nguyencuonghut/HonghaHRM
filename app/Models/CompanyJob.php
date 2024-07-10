<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_id',
        'division_id',
        'position_id',
        'insurance_salary',
        'position_salary',
        'max_capacity_salary',
        'position_allowance',
        'recruitment_standard_file'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function proposals()
    {
        return $this->hasMany(RecruitmentProposal::class);
    }

}
