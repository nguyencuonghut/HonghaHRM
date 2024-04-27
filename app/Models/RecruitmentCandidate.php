<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RecruitmentCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'name',
        'phone',
        'relative_phone',
        'date_of_birth',
        'cccd',
        'issued_date',
        'issued_by',
        'gender',
        'cv_file',
        'commune_id',
        'cv_receive_method',
        'batch',
        'note',
        'creator_id',
    ];

    public function proposals(): BelongsToMany
    {
        return $this->belongsToMany(RecruitmentProposal::class, 'proposal_candidate', 'candidate_id', 'proposal_id')->withTimestamps();;
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

    public function educations(): BelongsToMany
    {
        return $this->belongsToMany(Education::class, 'candidate_education', 'candidate_id', 'education_id')->withTimestamps();;
    }
}
