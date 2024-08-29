<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DecreaseInsurance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_work_id', 'confirmed_month'];

    public function employee_work(): BelongsTo
    {
        return $this->belongsTo(EmployeeWork::class);
    }
}
