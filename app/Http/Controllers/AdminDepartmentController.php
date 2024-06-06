<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use App\Models\CompanyJob;
use App\Models\Department;
use App\Models\Division;
use RealRashid\SweetAlert\Facades\Alert;

class AdminDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.department.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'code' => 'required|unique:departments',
            'name' => 'required|max:255',
        ];
        $messages = [
            'code.required' => 'Bạn phải nhập mã.',
            'code.unique' => 'Mã đã tồn tại.',
            'name.required' => 'Bạn phải nhập tên.',
            'name.max' => 'Tên dài quá 255 ký tự.',
        ];
        $request->validate($rules,$messages);

        //Create new Department
        $department = new Department();
        $department->name = $request->name;
        $department->code = $request->code;
        $department->save();

        Alert::toast('Thêm phòng ban mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.departments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('admin.department.edit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'code' => 'required|unique:departments,code,'.$id,
            'name' => 'required|max:255',
        ];
        $messages = [
            'code.required' => 'Bạn phải nhập mã.',
            'code.unique' => 'Mã đã tồn tại.',
            'name.required' => 'Bạn phải nhập tên.',
            'name.max' => 'Tên dài quá 255 ký tự.',
        ];
        $request->validate($rules,$messages);

        //Edit Department
        $department = Department::findOrFail($id);
        $department->name = $request->name;
        $department->code = $request->code;
        $department->save();

        Alert::toast('Sửa phòng ban thành công!', 'success', 'top-right');
        return redirect()->route('admin.departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        // Check condition before delete
        if ($department->divisions->count()) {
            Alert::toast('Phòng/ban đang chứa các bộ phận. Không thể xóa!', 'error', 'top-right');
            return redirect()->route('admin.departments.index');
        }
        $company_jobs = CompanyJob::where('department_id', $department->id)->get();
        if ($company_jobs->count()) {
            Alert::toast('Phòng/ban đang chứa nhân viên. Không thể xóa!', 'error', 'top-right');
            return redirect()->route('admin.departments.index');
        }
        $department->destroy($id);

        Alert::toast('Xóa phòng ban thành công!', 'success', 'top-right');
        return redirect()->route('admin.departments.index');
    }

    public function anyData()
    {
        $departments = Department::with('divisions')->select(['id', 'code', 'name'])->get();
        return Datatables::of($departments)
            ->addIndexColumn()
            ->editColumn('code', function ($departments) {
                return $departments->code;
            })
            ->editColumn('name', function ($departments) {
                return $departments->name;
            })
            ->editColumn('divisions', function ($departments) {
                $i = 0;
                $length = count($departments->divisions);
                $divisions = '';
                foreach ($departments->divisions as $division) {
                    if(++$i === $length) {
                        $divisions =  $divisions . $division->name;
                    } else {
                        $divisions = $divisions . $division->name . '<br>';
                    }
                }
                return $divisions;
            })
            ->editColumn('company_job_lists', function ($departments) {
                $company_jobs = CompanyJob::where('department_id', $departments->id)->orderBy('name')->get();
                $i = 0;
                $length = count($company_jobs);
                $company_job_lists = '';
                foreach ($company_jobs as $company_job) {
                    if(++$i === $length) {
                        $company_job_lists =  $company_job_lists . $company_job->name;
                    } else {
                        $company_job_lists = $company_job_lists . $company_job->name . '<br>';
                    }
                }
                return $company_job_lists;
            })
            ->addColumn('actions', function ($departments) {
                $action = '<a href="' . route("admin.departments.edit", $departments->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.departments.destroy", $departments->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'divisions', 'company_job_lists'])
            ->make(true);
    }

    public function getDivision($department_id)
    {
        $divisionData['data'] = Division::orderby("name","asc")
                                    ->select('id','name')
                                    ->where('department_id',$department_id)
                                    ->get();

        return response()->json($divisionData);

    }
}
