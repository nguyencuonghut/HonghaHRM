<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ProposalCandidateFilter extends Model
{
    use HasFactory;

    protected $fillable = ['work_location', 'salary', 'result', 'note', 'proposal_candidate_id'];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(ProposalCandidate::class);
    }

}
