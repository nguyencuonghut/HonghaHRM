<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Datatables;

class AdminReportController extends Controller
{
    public function birthday()
    {
        return view('admin.report.birthday');
    }

    public function situation()
    {
        dd("Situation report");

    }

    public function kid_policy()
    {
        dd("Kid policy report");

    }

    public function seniority()
    {
        dd("Seniority report");

    }

    public function birthdayData()
    {
        $employees = Employee::orderBy('name', 'asc')->get();
        return Datatables::of($employees)
            ->addIndexColumn()
            ->editColumn('name', function ($employees) {
                return '<a href="' . route("admin.hr.employees.show", $employees->id) . '">' . $employees->name . '</a>';

            })
            ->editColumn('department', function ($employees) {
                $employee_works = EmployeeWork::where('employee_id', $employees->id)
                                                ->where('status', 'On')
                                                ->get();
                $employee_department_str = '';
                $i = 0;
                $length = count($employee_works);
                if ($length) {
                    foreach ($employee_works as $employee_work) {
                        if(++$i === $length) {
                            $employee_department_str .= $employee_work->company_job->department->name;
                        } else {
                            $employee_department_str .= $employee_work->company_job->department->name . ' | ';
                        }
                    }
                }
                return $employee_department_str;
            })
            ->editColumn('division', function ($employees) {
                $employee_works = EmployeeWork::where('employee_id', $employees->id)
                                                ->where('status', 'On')
                                                ->get();
                $employee_division_str = '';
                $i = 0;
                $length = count($employee_works);
                if ($length) {
                    foreach ($employee_works as $employee_work) {
                        if ($employee_work->company_job->division_id) {
                            if(++$i === $length) {
                                $employee_division_str .= $employee_work->company_job->division->name;
                            } else {
                                $employee_division_str .= $employee_work->company_job->division->name . ' | ';
                            }
                        }
                    }
                }
                return $employee_division_str;
            })
            ->editColumn('date_of_birth', function ($employees) {
                return date('d/m/Y', strtotime($employees->date_of_birth));

            })
            ->rawColumns(['name', 'department', 'division'])
            ->make(true);
    }
}
