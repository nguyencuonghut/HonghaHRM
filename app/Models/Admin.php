<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = ['name', 'email',  'password', 'department_id', 'status'];

    protected $hidden = ['password',  'remember_token'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function proposals()
    {
        return $this->hasMany(RecruitmentProposal::class);
    }

    public function candidates()
    {
        return $this->hasMany(RecruitmentCandidate::class);
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'admin_department')->withTimestamps();;
    }
}
