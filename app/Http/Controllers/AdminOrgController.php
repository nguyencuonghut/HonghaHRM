<?php

namespace App\Http\Controllers;

use App\Models\CompanyJob;
use App\Models\Department;
use App\Models\DepartmentManager;
use App\Models\Employee;
use App\Models\EmployeeWork;
use App\Models\Division;
use App\Models\DivisionManager;
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
        $department = Department::findOrFail($department_id);
        $datasource = [];
        // Tạo root node (trưởng phòng) datasource cho OrgChart
        $department_manager = DepartmentManager::where('department_id', $department_id)->first();
        if ($department_manager) {
            $department_manager_employee = Employee::findOrFail($department_manager->manager_id);
        } else {
            $department_manager_employee = null;
        }
        if ($department_manager_employee) {
            $datasource = [
                'id' => $department_manager_employee->img_path,
                'name'=> $department_manager_employee->name,
                'title' => 'Trưởng phòng',
                'children' => [],
            ];

            // Tạo node phó phòng
            $pp_company_job_ids = CompanyJob::where('department_id', $department_id)->where('position_id', 7)->pluck('id')->toArray();
            $employee_pp_ids = EmployeeWork::whereIn('company_job_id', $pp_company_job_ids)->where('status', 'On')->pluck('employee_id')->toArray();
            $pp_employees = Employee::whereIn('id', $employee_pp_ids)->get();
            if ($pp_employees->count()) {
                foreach ($pp_employees as $item) {
                    $child = [
                        'id' => $item->img_path,
                        'name' => $item->name,
                        'title' => 'Phó phòng',
                        'children' => []
                    ];
                    array_push($datasource['children'], $child);
                }
            }

            // Tạo node trưởng nhóm/tổ trưởng
            $division_ids = Division::where('department_id', $department_id)->pluck('id')->toArray(); // Lấy các tổ/nhóm thuộc phòng ban
            $group_manager_ids = DivisionManager::whereIn('division_id', $division_ids)->pluck('manager_id')->toArray(); // Lấy các manager ids là quản lý các tổ/nhóm
            $group_manager_employees = Employee::whereIn('id', $group_manager_ids)->get();

            if ($group_manager_employees->count()) {
                // Trường hợp có phó phòng
                if ($pp_employees->count()) {
                    foreach ($group_manager_employees as $key => $item) {
                        $division_manager = DivisionManager::where('manager_id', $item->id)->first();
                        $child = [
                            'id' => $item->img_path,
                            'name' => $item->name,
                            'title' => 'Tổ trưởng' . ' ' . $division_manager->division->name,
                            'children' => []
                        ];
                        array_push($datasource['children'][0]['children'], $child);

                        //Lấy các Employee có chức vụ là Nhân viên thuộc tổ/nhóm
                        $company_job_nv_ids = CompanyJob::where('department_id', $department_id)->where('division_id', $division_manager->division_id)->where('position_id', 13)->pluck('id')->toArray();
                        $employee_nv_ids = EmployeeWork::whereIn('company_job_id', $company_job_nv_ids)->where('status', 'On')->pluck('employee_id')->toArray();
                        $nv_employees = Employee::whereIn('id', $employee_nv_ids)->get();

                        foreach ($nv_employees as $item) {
                            $child = [
                                'id' => $item->img_path,
                                'name' => $item->name,
                                'title' => 'Nhân viên' . ' ' . $division_manager->division->name,
                            ];
                            array_push($datasource['children'][0]['children'][$key]['children'], $child);
                        }

                        // Lấy các Employee có chức vụ là nhân viên mà Không thuộc tổ/nhóm
                        $remain_company_job_nv_ids = CompanyJob::where('department_id', $department_id)->whereNotIn('division_id', $division_ids)->where('position_id', 13)->pluck('id')->toArray();
                        $remain_employee_nv_ids = EmployeeWork::whereIn('company_job_id', $remain_company_job_nv_ids)->where('status', 'On')->pluck('employee_id')->toArray();
                        $remain_nv_employees = Employee::whereIn('id', $remain_employee_nv_ids)->get();
                        foreach ($remain_nv_employees as $item) {
                            $child = [
                                'id' => $item->img_path,
                                'name' => $item->name,
                                'title' => 'Nhân viên',
                            ];
                            array_push($datasource['children'], $child);
                        }
                    }
                } else { // Không có phó phòng
                    foreach ($group_manager_employees as $key => $item) {
                        $division_manager = DivisionManager::where('manager_id', $item->id)->first();
                        $child = [
                            'id' => $item->img_path,
                            'name' => $item->name,
                            'title' => 'Tổ trưởng' . ' ' . $division_manager->division->name,
                            'children' => []
                        ];
                        array_push($datasource['children'], $child);

                        //Lấy các Employee có chức vụ là Nhân viên thuộc tổ/nhóm
                        $company_job_nv_ids = CompanyJob::where('department_id', $department_id)->where('division_id', $division_manager->division_id)->where('position_id', 13)->pluck('id')->toArray();
                        $employee_nv_ids = EmployeeWork::whereIn('company_job_id', $company_job_nv_ids)->where('status', 'On')->pluck('employee_id')->toArray();
                        $nv_employees = Employee::whereIn('id', $employee_nv_ids)->get();

                        foreach ($nv_employees as $item) {
                            $child = [
                                'id' => $item->img_path,
                                'name' => $item->name,
                                'title' => 'Nhân viên' . ' ' . $division_manager->division->name,
                            ];
                            array_push($datasource['children'][$key]['children'], $child);
                        }


                        // Lấy các Employee có chức vụ là nhân viên mà Không thuộc tổ/nhóm
                        $remain_company_job_nv_ids = CompanyJob::where('department_id', $department_id)->where('division_id', '!=', $division_manager->division_id)->where('position_id', 13)->pluck('id')->toArray();
                        $remain_employee_nv_ids = EmployeeWork::whereIn('company_job_id', $remain_company_job_nv_ids)->where('status', 'On')->pluck('employee_id')->toArray();
                        $remain_nv_employees = Employee::whereIn('id', $remain_employee_nv_ids)->get();
                        foreach ($remain_nv_employees as $item) {
                            $child = [
                                'id' => $item->img_path,
                                'name' => $item->name,
                                'title' => 'Nhân viên',
                            ];
                            array_push($datasource['children'], $child);
                        }
                    }
                }
            }
        }
        return view('admin.org.show',
                    [
                        'department' => $department,
                        'department_manager_employee' => $department_manager_employee,
                        'datasource' => $datasource,
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
