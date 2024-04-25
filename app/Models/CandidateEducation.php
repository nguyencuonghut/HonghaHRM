<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CandidateEducation extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'education_id',
        'candidate_id',
        'major',
    ];
}
