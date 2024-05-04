<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstInterviewInvitation extends Model
{
    use HasFactory;

    protected $fillable = ['proposal_candidate_id', 'status', 'interview_time', 'interview_location', 'contact','feedback', 'note'];
}
