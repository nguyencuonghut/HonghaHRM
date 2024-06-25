<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeWork extends Model
{
    use HasFactory;

    protected $table = "employee_works";

    protected $fillable = ['employee_id', 'company_job_id', 'status', 'start_date', 'end_date'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function company_job(): BelongsTo
    {
        return $this->belongsTo(CompanyJob::class);
    }
}
