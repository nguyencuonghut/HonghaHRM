<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeRegime extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'regime_id', 'off_start_date', 'off_end_date', 'payment_period', 'payment_amount', 'status'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function regime(): BelongsTo
    {
        return $this->belongsTo(Regime::class);
    }
}
