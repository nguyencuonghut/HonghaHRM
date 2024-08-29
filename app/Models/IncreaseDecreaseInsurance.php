<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncreaseDecreaseInsurance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_work_id', 'increase_confirmed_month', 'decrease_confirmed_month', 'is_increase', 'is_decrease'];

    public function employee_work(): BelongsTo
    {
        return $this->belongsTo(EmployeeWork::class);
    }
}
