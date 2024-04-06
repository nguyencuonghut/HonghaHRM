<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The roles that belong to the user.
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'user_department')->withTimestamps();;
    }

    /**
     * The divisions that belong to the user.
     */
    public function divisions(): BelongsToMany
    {
        return $this->belongsToMany(Division::class, 'user_division')->withTimestamps();;
    }

    /**
     * The positions that belong to the user.
     */
    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'user_position')->withTimestamps();;
    }
}
