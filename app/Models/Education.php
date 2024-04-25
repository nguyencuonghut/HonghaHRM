<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Education extends Model
{
    use HasFactory;
    public $table = "educations";

    protected $fillable = ['name'];

    public function candidates(): BelongsToMany
    {
        return $this->belongsToMany(RecruitmentCandidate::class, 'candidate_education', 'candidate_id', 'education_id')->withTimestamps();;
    }
}
