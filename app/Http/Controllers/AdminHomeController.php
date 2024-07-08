<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\RecruitmentProposal;
use App\Models\Probation;
use App\Models\Department;
use App\Models\EmployeeRelative;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminHomeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $recruitment_proposals = RecruitmentProposal::all();
        $probations = Probation::all();
        $departments = Department::all();

        // Employees have birthday this month
        $birthdays = Employee::whereMonth('date_of_birth', Carbon::now()->month)->get();
        // Employees have special situation
        $employee_relative_ids = EmployeeRelative::where('situation', '!=', null)->pluck('id')->toArray();
        $situations = Employee::whereIn('id', $employee_relative_ids)->get();
        // Get Employee's kids that smaller than 15 years old
        $kid_policies = EmployeeRelative::whereIn('type', ['Con trai', 'Con gái'])
                                        ->where('year_of_birth', '>=', Carbon::now()->year - 15)
                                        ->get();
        // Employees joined in company more than 5 years
        $seniorities = Employee::whereYear('join_date', '<=', Carbon::now()->year - 5)
                            ->get();

        return view('admin.home',
                    [
                        'employees' => $employees,
                        'recruitment_proposals' => $recruitment_proposals,
                        'probations' => $probations,
                        'departments' => $departments,
                        'birthdays' => $birthdays,
                        'situations' => $situations,
                        'kid_policies' => $kid_policies,
                        'seniorities' => $seniorities,
                    ]);
    }
}
