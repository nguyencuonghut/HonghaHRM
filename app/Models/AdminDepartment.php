<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDepartment extends Model
{
    use HasFactory;

    protected $table = "admin_department";

    protected $fillable = ['admin_id', 'department_id'];
}
