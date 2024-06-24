<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeWork extends Model
{
    use HasFactory;

    protected $table = "employee_works";

    protected $fillable = ['employee_id', 'company_job_id', 'status', 'start_date', 'end_date'];
}
