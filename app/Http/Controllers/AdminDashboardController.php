<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Probation;
use App\Models\RecruitmentProposal;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboard_1()
    {
        $employees = Employee::all();
        $recruitment_proposals = RecruitmentProposal::all();
        $probations = Probation::all();
        $departments = Department::all();
        return view('admin.dashboard.dashboard_1',
                    [
                        'employees' => $employees,
                        'recruitment_proposals' => $recruitment_proposals,
                        'probations' => $probations,
                        'departments' => $departments,
                    ]);
    }
}
