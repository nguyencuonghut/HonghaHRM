<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = ['code',  'name'];

    /**
     * The users that belong to the department.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_department')->withTimestamps();;
    }

    /**
     * The devisions that belong to the department.
     */
    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function proposals()
    {
        return $this->hasMany(RecruitmentProposal::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
