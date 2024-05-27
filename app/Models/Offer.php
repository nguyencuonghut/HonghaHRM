<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['current_salary',
                           'desired_salary',
                           'detail',
                           'note',
                           'feedback',
                           'result',
                           'proposal_candidate',
                           'creator_id',
                           'approver_id'
                        ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
