<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentProposal extends Model
{
    use HasFactory;

    protected $fillable = ['job',
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

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
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
}
