<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecruitmentCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'name',
        'phone',
        'date_of_birth',
        'cccd',
        'issued_date',
        'issued_by',
        'gender',
        'cv_file',
        'commune_id',
        'cv_receive_method',
        'batch',
        'creator_id',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(RecruitmentProposal::class);
    }

    public function cv_receive_method(): BelongsTo
    {
        return $this->belongsTo(CvReceiveMethod::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }
}
