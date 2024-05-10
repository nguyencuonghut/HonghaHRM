<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitialInterview extends Model
{
    use HasFactory;

    protected $fillable = [
                            'proposal_candidate_id',
                            'reviewer_id',
                            'health_comment',
                            'health_score',
                            'attitude_comment',
                            'attitude_score',
                            'stability_comment',
                            'stability_score',
                            'total_score',
                            'result',
                        ];
}
