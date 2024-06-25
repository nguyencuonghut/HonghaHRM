<?php

namespace App\Http\Controllers;

use App\Models\EmployeeWork;
use Datatables;
use Illuminate\Http\Request;

class AdminOrgController extends Controller
{
    public function index()
    {
        return view('admin.org.index');
    }

    public function anyData()
    {
        $employee_works = EmployeeWork::with(['employee', 'company_job'])->where('status', 'On')->get();
        return Datatables::of($employee_works)
            ->addIndexColumn()
            ->editColumn('department', function ($employee_works) {
                return $employee_works->company_job->department->name;
            })
            ->editColumn('division', function ($employee_works) {
                if ($employee_works->company_job->division_id) {
                    return $employee_works->company_job->division->name;
                } else {
                    return '-';
                }
            })
            ->editColumn('employee', function ($employee_works) {
                return '<a href=' . route("admin.hr.employees.show", $employee_works->employee_id) .'>' . $employee_works->employee->name . ' - ' . $employee_works->company_job->name . '</a>';
            })
            ->rawColumns(['employee'])
            ->make(true);
    }
}
