<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RecruitmentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(RecruitmentPlan::class, 'plan_method')->withTimestamps();;
    }
}
