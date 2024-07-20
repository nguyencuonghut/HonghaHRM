<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EmployeeInsurance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'insurance_id', 'start_date', 'end_date', 'pay_rate'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function insurance(): BelongsTo
    {
        return $this->belongsTo(Insurance::class);
    }

}
