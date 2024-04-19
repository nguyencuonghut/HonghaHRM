<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecruitmentPlan extends Model
{
    use HasFactory;

    protected $fillable = ['proposal_id', 'budget', 'creator', 'approver', 'approver_result', 'approver_comment', 'status'];

    public function methods(): BelongsToMany
    {
        return $this->belongsToMany(RecruitmentMethod::class, 'plan_method', 'plan_id', 'method_id')->withTimestamps();;
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(RecruitmentProposal::class);
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'creator_id');
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approver_id');
    }
}
