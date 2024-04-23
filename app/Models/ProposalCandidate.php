<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProposalCandidate extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'candidate_id',
        'cv_file',
        'cv_receive_method_id',
        'batch',
        'creator_id',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
