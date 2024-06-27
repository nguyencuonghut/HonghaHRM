<?php

namespace App\Http\Controllers;

use App\Models\CompanyJob;
use App\Models\Department;
use App\Models\Division;
use App\Models\Position;
use Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminCompanyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->can('view-salary')) {
            $can_view_salary = true;
        } else {
            $can_view_salary = false;
        }
        return view('admin.company_job.index', ['can_view_salary' => $can_view_salary]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all()->pluck('name', 'id');
        $divisions = Division::all()->pluck('name', 'id');
        $positions = Position::all()->pluck('name', 'id');
        return view('admin.company_job.create',
                    [
                        'departments' => $departments,
                        'divisions' => $divisions,
                        'positions' => $positions,
                    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'sel_department' => 'required',
            'position_id' => 'required',
            'position_salary' => 'required',
            'max_capacity_salary' => 'required',
            'position_allowance' => 'required',
            'recruitment_standard_file' => 'required',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'sel_department.required' => 'Bạn phải chọn phòng ban.',
            'position_id.required' => 'Bạn phải chọn chức vụ',
            'position_salary.required' => 'Bạn phải nhập lương vị trí.',
            'max_capacity_salary.required' => 'Bạn phải nhập lương năng lực max.',
            'position_allowance.required' => 'Bạn phải nhập phụ cấp vị trí.',
            'recruitment_standard_file.required' => 'Bạn phải chọn file tiêu chuẩn tuyển dụng.',
        ];
        $request->validate($rules,$messages);

        $company_job = new CompanyJob();
        $company_job->name = $request->name;
        $company_job->department_id = $request->sel_department;
        $company_job->position_id = $request->position_id;
        if ($request->sel_division) {
            $company_job->division_id = $request->sel_division;
        }
        $company_job->position_salary = $request->position_salary;
        $company_job->max_capacity_salary = $request->max_capacity_salary;
        $company_job->position_allowance = $request->position_allowance;

        if ($request->hasFile('recruitment_standard_file')) {
            $path = 'dist/recruitment_standard';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('recruitment_standard_file');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $company_job->recruitment_standard_file = $path . '/' . $name;
        }
        $company_job->save();

        Alert::toast('Thêm vị trí mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!Auth::user()->can('create-company-job')) {
            Alert::toast('Bạn không có quyền sửa vị trí này!', 'error', 'top-right');
            return redirect()->back();
        }

        $departments = Department::all();
        $divisions = Division::all();
        $positions = Position::all();
        $company_job = CompanyJob::findOrFail($id);
        return view('admin.company_job.edit',
                    ['departments' => $departments,
                    'divisions' => $divisions,
                    'positions' => $positions,
                    'company_job' => $company_job
                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'sel_department' => 'required',
            'position_id' => 'required',
            'position_salary' => 'required',
            'max_capacity_salary' => 'required',
            'position_allowance' => 'required',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'sel_department.required' => 'Bạn phải chọn phòng ban.',
            'position_id.required' => 'Bạn phải chọn chức vụ',
            'position_salary.required' => 'Bạn phải nhập lương vị trí.',
            'max_capacity_salary.required' => 'Bạn phải nhập lương năng lực max.',
            'position_allowance.required' => 'Bạn phải nhập phụ cấp vị trí.',
        ];
        $request->validate($rules,$messages);

        $company_job = CompanyJob::findOrFail($id);
        $company_job->name = $request->name;
        $company_job->department_id = $request->sel_department;
        $company_job->position_id = $request->position_id;
        if ($request->sel_division) {
            $company_job->division_id = $request->sel_division;
        } else {
            $company_job->division_id = null;
        }
        $company_job->position_salary = $request->position_salary;
        $company_job->max_capacity_salary = $request->max_capacity_salary;
        $company_job->position_allowance = $request->position_allowance;

        if ($request->hasFile('recruitment_standard_file')) {
            $path = 'dist/recruitment_standard';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('recruitment_standard_file');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $company_job->recruitment_standard_file = $path . '/' . $name;
        }
        $company_job->save();

        Alert::toast('Sửa vị trí mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.company_jobs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('create-company-job')) {
            Alert::toast('Bạn không có quyền xóa vị trí này!', 'error', 'top-right');
            return redirect()->back();
        }
        $company_job = CompanyJob::findOrFail($id);
        $company_job->destroy($company_job->id);
        Alert::toast('Xóa vị trí thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function anyData()
    {
        $company_jobs = CompanyJob::with(['department', 'division', 'position'])->select(['id', 'name', 'department_id', 'position_id', 'division_id', 'position_salary', 'max_capacity_salary', 'position_allowance', 'recruitment_standard_file'])->get();
        return Datatables::of($company_jobs)
            ->addIndexColumn()
            ->editColumn('name', function ($company_jobs) {
                return $company_jobs->name;
            })
            ->editColumn('department', function ($company_jobs) {
                return $company_jobs->department->name;
            })
            ->editColumn('position', function ($company_jobs) {
                return $company_jobs->position->name;
            })
            ->editColumn('division', function ($company_jobs) {
                if ($company_jobs->division_id) {
                    return $company_jobs->division->name;
                } else {
                    return '-';
                }
            })
            ->editColumn('position_salary', function ($company_jobs) {
                return number_format($company_jobs->position_salary, 0, '.', ',') . '<sup>đ</sup>';
            })
            ->editColumn('max_capacity_salary', function ($company_jobs) {
                return number_format($company_jobs->max_capacity_salary, 0, '.', ',') . '<sup>đ</sup>';
            })
            ->editColumn('position_allowance', function ($company_jobs) {
                return number_format($company_jobs->position_allowance, 0, '.', ',') . '<sup>đ</sup>';
            })
            ->editColumn('recruitment_standard_file', function ($company_jobs) {
                return '<a target="_blank" href="../../../' . $company_jobs->recruitment_standard_file . '"><i class="far fa-file-pdf"></i></a>';
            })
            ->addColumn('actions', function ($company_jobs) {
                $action = '<a href="' . route("admin.company_jobs.edit", $company_jobs->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.company_jobs.destroy", $company_jobs->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'recruitment_standard_file', 'division', 'position_salary', 'max_capacity_salary', 'position_allowance'])
            ->make(true);
    }
}
