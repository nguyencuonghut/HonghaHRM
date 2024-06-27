<?php

namespace App\Http\Controllers;

use App\Models\CompanyJob;
use App\Models\Employee;
use App\Models\EmployeeWork;
use Datatables;
use Illuminate\Http\Request;

class AdminOrgController extends Controller
{
    public function index()
    {
        return view('admin.org.index');
    }

    public function show($department_id)
    {
        // Lấy các Nhân viên có chức vụ là Giám Đốc Khối
        $company_job_gdk_ids = CompanyJob::where('department_id', $department_id)->where('position_id', 2)->pluck('id')->toArray();
        $employee_gdk_ids = EmployeeWork::whereIn('company_job_id', $company_job_gdk_ids)->pluck('employee_id')->toArray();
        $gdk_employees = Employee::whereIn('id', $employee_gdk_ids)->get();
        // Lấy các Nhân viên có chức vụ là Giám đốc
        $company_job_gd_ids = CompanyJob::where('department_id', $department_id)->where('position_id', 3)->pluck('id')->toArray();
        $employee_gd_ids = EmployeeWork::whereIn('company_job_id', $company_job_gd_ids)->pluck('employee_id')->toArray();
        $gd_employees = Employee::whereIn('id', $employee_gd_ids)->get();
        // Lấy các Nhân viên có chức vụ là Trưởng phòng
        $company_job_tp_ids = CompanyJob::where('department_id', $department_id)->where('position_id', 5)->pluck('id')->toArray();
        $employee_tp_ids = EmployeeWork::whereIn('company_job_id', $company_job_tp_ids)->pluck('employee_id')->toArray();
        $tp_employees = Employee::whereIn('id', $employee_tp_ids)->get();
        // Lấy các Nhân viên có chức vụ là Trưởng nhóm
        $company_job_tn_ids = CompanyJob::where('department_id', $department_id)->where('position_id', 8)->pluck('id')->toArray();
        $employee_tn_ids = EmployeeWork::whereIn('company_job_id', $company_job_tn_ids)->pluck('employee_id')->toArray();
        $tn_employees = Employee::whereIn('id', $employee_tn_ids)->get();
        // Lấy các Nhân viên có chức vụ là Nhân viên
        $company_job_nv_ids = CompanyJob::where('department_id', $department_id)->where('position_id', 13)->pluck('id')->toArray();
        $employee_nv_ids = EmployeeWork::whereIn('company_job_id', $company_job_nv_ids)->pluck('employee_id')->toArray();
        $nv_employees = Employee::whereIn('id', $employee_nv_ids)->get();

        return view('admin.org.show',
                    [
                        'gdk_employees' => $gdk_employees,
                        'gd_employees' => $gd_employees,
                        'tp_employees' => $tp_employees,
                        'tn_employees' => $tn_employees,
                        'nv_employees' => $nv_employees,
                    ]);
    }


    public function anyData()
    {
        $employee_works = EmployeeWork::with(['employee', 'company_job'])->where('status', 'On')->get();
        return Datatables::of($employee_works)
            ->addIndexColumn()
            ->editColumn('department', function ($employee_works) {
                return '<a href="' . route("admin.hr.orgs.show", $employee_works->company_job->department_id) .'">' . $employee_works->company_job->department->name . '</a>';
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
            ->rawColumns(['department', 'employee'])
            ->make(true);
    }
}
