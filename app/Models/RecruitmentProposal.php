<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RecruitmentProposal extends Model
{
    use HasFactory;

    protected $fillable = ['company_job_id',
                            'quantity',
                            'reason',
                            'requirement',
                            'salary',
                            'work_time',
                            'note',
                            'status',
                            'creator_id',
                            'reviewer_id',
                            'reviewer_result',
                            'reviewer_comment',
                            'approver_id',
                            'approver_result',
                            'approver_comment'
                            ];

    public function company_job()
    {
        return $this->belongsTo(CompanyJob::class, 'company_job_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'creator_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(Admin::class, 'reviewer_id');
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approver_id');
    }

    public function plan(): HasOne
    {
        return $this->hasOne(RecruitmentPlan::class, 'proposal_id');
    }

    public function announcement(): HasOne
    {
        return $this->hasOne(RecruitmentAnnouncement::class, 'proposal_id');
    }

    public function candidates()
    {
        return $this->hasMany(RecruitmentCandidate::class);
    }
}
