<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeAppendix extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'employee_id','employee_contract_id', 'description', 'reason', 'file_path'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function employee_contract(): BelongsTo
    {
        return $this->belongsTo(EmployeeContract::class);
    }
}
