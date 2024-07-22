<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeWelfare extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'welfare_id', 'payment_date', 'payment_amount', 'status'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function welfare(): BelongsTo
    {
        return $this->belongsTo(Welfare::class);
    }
}
