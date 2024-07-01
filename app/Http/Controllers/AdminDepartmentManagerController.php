<?php

namespace App\Http\Controllers;
use App\Models\CompanyJob;
use App\Models\Department;
use App\Models\DepartmentManager;
use App\Models\EmployeeWork;
use App\Models\Employee;
use Illuminate\Http\Request;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class AdminDepartmentManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.department_manager.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderBy('name', 'asc')->get();

        $manager_position_ids = [2,3,4,5,7]; //GĐK, GĐ, PGĐ, TP, PP
        $manager_company_job_ids = CompanyJob::whereIn('position_id', $manager_position_ids)->pluck('id')->toArray();
        $manager_employee_ids = EmployeeWork::whereIn('company_job_id', $manager_company_job_ids)->pluck('employee_id')->toArray();
        $managers = Employee::whereIn('id', $manager_employee_ids)->orderBy('name', 'asc')->get();
        return view('admin.department_manager.create',
                    [
                        'departments' => $departments,
                        'managers' => $managers,
                    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'department_id' => 'required|unique:department_managers',
            'manager_id' => 'required',
        ];
        $messages = [
            'department_id.required' => 'Bạn phải chọn phòng/ban.',
            'department_id.unique' => 'Phòng/ban đã có quản lý.',
            'manager_id.required' => 'Bạn phải chọn người quản lý.',
        ];
        $request->validate($rules, $messages);

        $department_manager = new DepartmentManager();
        $department_manager->department_id = $request->department_id;
        $department_manager->manager_id = $request->manager_id;
        $department_manager->save();

        Alert::toast('Thêm quản lý phòng ban mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.department_managers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentManager $departmentManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $department_manager = DepartmentManager::findOrFail($id);

        $departments = Department::orderBy('name', 'asc')->get();
        $manager_position_ids = [2,3,4,5,7]; //GĐK, GĐ, PGĐ, TP, PP
        $manager_company_job_ids = CompanyJob::whereIn('position_id', $manager_position_ids)->pluck('id')->toArray();
        $manager_employee_ids = EmployeeWork::whereIn('company_job_id', $manager_company_job_ids)->pluck('employee_id')->toArray();
        $managers = Employee::whereIn('id', $manager_employee_ids)->orderBy('name', 'asc')->get();
        return view('admin.department_manager.edit',
                    [
                        'department_manager' => $department_manager,
                        'departments' => $departments,
                        'managers' => $managers,

                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'department_id' => 'required|unique:department_managers,department_id,'.$id,
            'manager_id' => 'required',
        ];
        $messages = [
            'department_id.required' => 'Bạn phải chọn phòng/ban.',
            'department_id.unique' => 'Phòng/ban đã có quản lý.',
            'manager_id.required' => 'Bạn phải chọn người quản lý.',
        ];
        $request->validate($rules, $messages);

        $department_manager = DepartmentManager::findOrFail($id);
        $department_manager->department_id = $request->department_id;
        $department_manager->manager_id = $request->manager_id;
        $department_manager->save();

        Alert::toast('Sửa quản lý phòng ban thành công!', 'success', 'top-right');
        return redirect()->route('admin.department_managers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $department_manager = DepartmentManager::findOrFail($id);
        $department_manager->destroy($id);

        Alert::toast('Xóa quản lý phòng ban thành công!', 'success', 'top-right');
        return redirect()->route('admin.department_managers.index');
    }

    public function anyData()
    {
        $department_managers = DepartmentManager::with('department', 'manager')->get();
        return Datatables::of($department_managers)
            ->addIndexColumn()
            ->editColumn('department', function ($department_managers) {
                return '<a href="' . route("admin.hr.orgs.show", $department_managers->department_id) . '">' . $department_managers->department->name . '</a>';

            })
            ->editColumn('manager', function ($department_managers) {
                return '<a href="' . route("admin.hr.employees.show", $department_managers->manager_id) . '">' . $department_managers->manager->name . '</a>';
            })
            ->addColumn('actions', function ($department_managers) {
                $action = '<a href="' . route("admin.department_managers.edit", $department_managers->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.department_managers.destroy", $department_managers->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['department', 'manager','actions'])
            ->make(true);
    }
}
