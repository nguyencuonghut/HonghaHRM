<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EmployeeContract extends Model
{
    use HasFactory;

    protected $table = "employee_contracts";

    protected $fillable = ['code', 'employee_id', 'company_job_id', 'contract_type_id', 'file_path', 'status', 'start_date', 'end_date', 'request_terminate_date'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function company_job(): BelongsTo
    {
        return $this->belongsTo(CompanyJob::class);
    }

    public function contract_type(): BelongsTo
    {
        return $this->belongsTo(ContractType::class);
    }
}
