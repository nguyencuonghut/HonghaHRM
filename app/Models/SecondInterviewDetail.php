<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondInterviewDetail extends Model
{
    use HasFactory;

    protected $fillable = ['proposal_candidate_id', 'content', 'comment', 'score'];
}
