<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstInterviewResult extends Model
{
    use HasFactory;

    protected $fillable = ['proposal_candidate_id', 'result', 'interviewer_id'];

    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
