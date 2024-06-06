<?php

namespace App\Http\Controllers;

use App\Models\CompanyJob;
use App\Models\Department;
use App\Models\Division;
use Datatables;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.division.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view ('admin.division.create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'code' => 'required|unique:divisions',
            'name' => 'required|max:255',
            'department_id' => 'required',
        ];
        $messages = [
            'code.required' => 'Bạn phải nhập mã.',
            'code.unique' => 'Mã đã tồn tại.',
            'name.required' => 'Bạn phải nhập tên.',
            'name.max' => 'Tên dài quá 255 ký tự.',
            'department_id.required' => 'Bạn chọn phòng.',
        ];
        $request->validate($rules,$messages);

        //Create new Division
        $division = new Division();
        $division->name = $request->name;
        $division->code = $request->code;
        $division->department_id = $request->department_id;
        $division->save();

        Alert::toast('Thêm bộ phận mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.divisions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $departments = Department::all();
        $division = Division::findOrFail($id);
        return view ('admin.division.edit', ['departments' => $departments, 'division' => $division]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'code' => 'required|unique:divisions,code,'.$id,
            'name' => 'required|max:255',
            'department_id' => 'required',
        ];
        $messages = [
            'code.required' => 'Bạn phải nhập mã.',
            'code.unique' => 'Mã đã tồn tại.',
            'name.required' => 'Bạn phải nhập tên.',
            'name.max' => 'Tên dài quá 255 ký tự.',
            'department_id.required' => 'Bạn chọn phòng.',
        ];
        $request->validate($rules,$messages);

        //Edit Division
        $division = Division::findOrFail($id);
        $division->name = $request->name;
        $division->code = $request->code;
        $division->department_id = $request->department_id;
        $division->save();

        Alert::toast('Sửa bộ phận thành công!', 'success', 'top-right');
        return redirect()->route('admin.divisions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $division = Division::findOrFail($id);
        // Check condition before delete
        $company_jobs = CompanyJob::where('division_id', $division->id)->get();
        if ($company_jobs->count()) {
            Alert::toast('Bộ phận đang có chứa vị trí công việc. Không thể xóa!', 'error', 'top-right');
            return redirect()->route('admin.divisions.index');
        }
        $division->destroy($id);
        Alert::toast('Xóa phòng ban thành công!', 'success', 'top-right');
        return redirect()->route('admin.departments.index');
    }

    public function anyData()
    {
        $divisions = Division::with('department')->orderBy('department_id', 'asc')->select(['id', 'code', 'name', 'department_id'])->get();
        return Datatables::of($divisions)
            ->addIndexColumn()
            ->editColumn('code', function ($divisions) {
                return $divisions->code;
            })
            ->editColumn('name', function ($divisions) {
                return $divisions->name;
            })
            ->editColumn('department_id', function ($divisions) {
                return $divisions->department->name;
            })
            ->editColumn('company_job_lists', function ($divisions) {
                $company_jobs = CompanyJob::where('division_id', $divisions->id)->orderBy('name')->get();
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
            ->addColumn('actions', function ($divisions) {
                $action = '<a href="' . route("admin.divisions.edit", $divisions->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.divisions.destroy", $divisions->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'company_job_lists'])
            ->make(true);
    }
}
