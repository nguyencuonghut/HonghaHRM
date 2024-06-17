<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'img_path',
        'private_email',
        'company_email',
        'phone',
        'relative_phone',
        'date_of_birth',
        'cccd',
        'issued_date',
        'issued_by',
        'gender',
        'address',
        'commune_id',
        'temporary_address',
        'temporary_commune_id',
        'company_job_id',
        'experience',
    ];

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function temporary_commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function company_job(): BelongsTo
    {
        return $this->belongsTo(CompanyJob::class);
    }

    public function schools(): BelongsToMany
    {


        return $this->belongsToMany(School::class, 'employee_school', 'employee_id', 'school_id')->withTimestamps();;
    }

    public function probations(): HasMany
    {
        return $this->hasMany(Probation::class);
    }
}
