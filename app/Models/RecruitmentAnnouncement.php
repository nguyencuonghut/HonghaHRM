<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecruitmentAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = ['proposal_id', 'status'];

    public function social_media(): BelongsToMany
    {
        return $this->belongsToMany(RecruitmentSocialMedia::class, 'announcement_social_media', 'announcement_id', 'social_media_id')->withTimestamps();;
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(RecruitmentProposal::class);
    }
}
