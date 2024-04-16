<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'code',  'name'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * The users that belong to the department.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_division')->withTimestamps();;
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
