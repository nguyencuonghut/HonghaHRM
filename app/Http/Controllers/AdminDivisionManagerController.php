<?php

namespace App\Http\Controllers;
use App\Models\CompanyJob;
use App\Models\Division;
use App\Models\DivisionManager;
use App\Models\Employee;
use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class AdminDivisionManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.division_manager.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::orderBy('name', 'asc')->get();

        $manager_position_ids = [8,9,10,15]; //Trưởng nhóm/Tổ trưởng/Trưởng ca/Trưởng bộ phận
        $manager_company_job_ids = CompanyJob::whereIn('position_id', $manager_position_ids)->pluck('id')->toArray();
        $manager_employee_ids = EmployeeWork::whereIn('company_job_id', $manager_company_job_ids)->pluck('employee_id')->toArray();
        $managers = Employee::whereIn('id', $manager_employee_ids)->orderBy('name', 'asc')->get();
        return view('admin.division_manager.create',
                    [
                        'divisions' => $divisions,
                        'managers' => $managers,
                    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'division_id' => 'required|unique:division_managers',
            'manager_id' => 'required',
        ];
        $messages = [
            'division_id.required' => 'Bạn phải chọn tổ/nhóm.',
            'division_id.unique' => 'Tổ/nhóm đã có quản lý.',
            'manager_id.required' => 'Bạn phải chọn người quản lý.',
        ];
        $request->validate($rules, $messages);

        $division_manager = new DivisionManager();
        $division_manager->division_id = $request->division_id;
        $division_manager->manager_id = $request->manager_id;
        $division_manager->save();

        Alert::toast('Thêm quản lý tổ/nhóm mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.division_managers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DivisionManager $divisionManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $division_manager = DivisionManager::findOrFail($id);

        $divisions = Division::orderBy('name', 'asc')->get();
        $manager_position_ids = [8,9,10,15]; //Trưởng nhóm/Tổ trưởng/Trưởng ca/Trưởng bộ phận
        $manager_company_job_ids = CompanyJob::whereIn('position_id', $manager_position_ids)->pluck('id')->toArray();
        $manager_employee_ids = EmployeeWork::whereIn('company_job_id', $manager_company_job_ids)->pluck('employee_id')->toArray();
        $managers = Employee::whereIn('id', $manager_employee_ids)->orderBy('name', 'asc')->get();
        return view('admin.division_manager.edit',
                    [
                        'division_manager' => $division_manager,
                        'divisions' => $divisions,
                        'managers' => $managers,

                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'division_id' => 'required|unique:division_managers,division_id,'.$id,
            'manager_id' => 'required',
        ];
        $messages = [
            'division_id.required' => 'Bạn phải chọn tổ/nhóm.',
            'division_id.unique' => 'Tổ/nhóm đã có quản lý.',
            'manager_id.required' => 'Bạn phải chọn người quản lý.',
        ];
        $request->validate($rules, $messages);

        $division_manager = DivisionManager::findOrFail($id);
        $division_manager->division_id = $request->division_id;
        $division_manager->manager_id = $request->manager_id;
        $division_manager->save();

        Alert::toast('Sửa quản lý phòng ban thành công!', 'success', 'top-right');
        return redirect()->route('admin.division_managers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $division_manager = DivisionManager::findOrFail($id);
        $division_manager->destroy($id);

        Alert::toast('Xóa quản lý phòng ban thành công!', 'success', 'top-right');
        return redirect()->route('admin.division_managers.index');
    }

    public function anyData()
    {
        $division_managers = DivisionManager::with('division', 'manager')->get();
        return Datatables::of($division_managers)
            ->addIndexColumn()
            ->editColumn('division', function ($division_managers) {
                return $division_managers->division->name;

            })
            ->editColumn('manager', function ($division_managers) {
                return '<a href="' . route("admin.hr.employees.show", $division_managers->manager_id) . '">' . $division_managers->manager->name . '</a>';
            })
            ->addColumn('actions', function ($division_managers) {
                $action = '<a href="' . route("admin.division_managers.edit", $division_managers->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.division_managers.destroy", $division_managers->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['manager','actions'])
            ->make(true);
    }
}
