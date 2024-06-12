<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalCandidateEmployee extends Model
{
    use HasFactory;

    protected $fillable = ['proposal_candidate_id', 'employee_id'];
}
