<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RecruitmentSocialMedia extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function announcements(): BelongsToMany
    {
        return $this->belongsToMany(RecruitmentAnnouncement::class, 'announcement_social_media')->withTimestamps();;
    }
}
