<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSchool extends Model
{
    use HasFactory;

    public $table = "employee_school";

    protected $fillable = [
        'school_id',
        'employee_id',
        'degree_id',
        'major',
    ];
}
