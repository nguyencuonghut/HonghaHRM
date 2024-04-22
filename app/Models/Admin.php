<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = ['email',  'password'];

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
}
