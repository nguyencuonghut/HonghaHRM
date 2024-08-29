<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeWork extends Model
{
    use HasFactory;

    protected $table = "employee_works";

    protected $fillable = ['contract_code', 'employee_id', 'company_job_id', 'status', 'start_date', 'end_date', 'on_type_id','off_type_id', 'off_reason'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function company_job(): BelongsTo
    {
        return $this->belongsTo(CompanyJob::class);
    }

    public function on_type(): BelongsTo
    {
        return $this->belongsTo(OnType::class);
    }

    public function off_type(): BelongsTo
    {
        return $this->belongsTo(OffType::class);
    }
}
