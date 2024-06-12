<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CandidateSchool extends Pivot
{
    use HasFactory;

    public $table = "candidate_school";

    protected $fillable = [
        'school_id',
        'candidate_id',
        'major',
    ];
}
