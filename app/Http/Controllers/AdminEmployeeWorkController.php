<?php

namespace App\Http\Controllers;

use App\Models\CompanyJob;
use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.working.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company_jobs = CompanyJob::all();
        return view('admin.working.create', ['company_jobs' => $company_jobs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'employee_id' => 'required',
            'company_job_id' => 'required',
            's_date' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số Id nhân sự chưa có.',
            'company_job_id.required' => 'Bạn cần chọn Vị trí.',
            's_date.required' => 'Bạn cần nhập ngày bắt đầu.',
        ];

        $request->validate($rules, $messages);

        // Create new EmployeeWork
        $employee_work = new EmployeeWork();
        $employee_work->employee_id = $request->employee_id;
        $employee_work->company_job_id = $request->company_job_id;
        $employee_work->start_date = Carbon::createFromFormat('d/m/Y', $request->s_date);
        $employee_work->status = 'On';
        $employee_work->save();

        Alert::toast('Thêm quá trình làm việc mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_work = EmployeeWork::findOrFail($id);
        $company_jobs = CompanyJob::all();
        return view('admin.working.edit', [
            'employee_work' => $employee_work,
            'company_jobs' => $company_jobs
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'company_job_id' => 'required',
            's_date' => 'required',
        ];

        $messages = [
            'company_job_id.required' => 'Bạn cần chọn Vị trí.',
            's_date.required' => 'Bạn cần nhập ngày bắt đầu.',
        ];

        $request->validate($rules, $messages);

        // Edit EmployeeWork
        $employee_work = EmployeeWork::findOrFail($id);
        $employee_work->company_job_id = $request->company_job_id;
        $employee_work->start_date = Carbon::createFromFormat('d/m/Y', $request->s_date);
        $employee_work->save();

        Alert::toast('Sửa quá trình làm việc mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.employees.show', $employee_work->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_work = EmployeeWork::findOrFail($id);
        $employee_work->destroy($id);

        Alert::toast('Xóa quá trình làm việc mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function getOff($id)
    {
        $employee_work = EmployeeWork::findOrFail($id);
        return view('admin.working.off', ['employee_work' => $employee_work]);
    }

    public function off(Request $request, $id)
    {
        $rules = [
            'e_date' => 'required',
        ];

        $messages = [
            'e_date.required' => 'Bạn phải nhập ngày kết thúc.',
        ];

        $request->validate($rules, $messages);

        // Off the EmployeeWork
        $employee_work = EmployeeWork::findOrFail($id);
        $employee_work->status = 'Off';
        $employee_work->end_date = Carbon::createFromFormat('d/m/Y', $request->e_date);
        $employee_work->save();

        Alert::toast('Cập nhật thành công!', 'success', 'top-right');
        return redirect()->route('admin.employees.show', $employee_work->employee_id);
    }

    public function anyData()
    {
        $employee_works = EmployeeWork::orderBy('employee_id', 'asc')->get();
        return Datatables::of($employee_works)
            ->addIndexColumn()
            ->editColumn('employee_name', function ($employee_works) {
                return '<a href=' . route("admin.employees.show", $employee_works->employee_id) . '>' . $employee_works->employee->name . '</a>' ;
            })
            ->editColumn('company_job', function ($employee_works) {
                if ($employee_works->company_job->division_id) {
                    return $employee_works->company_job->name . ' - ' . $employee_works->company_job->division->name .  '- ' . $employee_works->company_job->department->name;

                } else {
                    return $employee_works->company_job->name . ' - ' . $employee_works->company_job->department->name;
                }
            })
            ->editColumn('start_date', function ($employee_works) {
                return date('d/m/Y', strtotime($employee_works->start_date));
            })
            ->editColumn('end_date', function ($employee_works) {
                if ($employee_works->end_date) {
                    return date('d/m/Y', strtotime($employee_works->end_date));
                } else {
                    return '-';
                }
            })
            ->editColumn('status', function ($employee_works) {
                if ('On' == $employee_works->status) {
                    return '<span class="badge badge-success">' . $employee_works->status . '</span>';
                } else {
                    return '<span class="badge badge-danger">' . $employee_works->status . '</span>';
                }
            })
            ->rawColumns(['employee_name', 'status'])
            ->make(true);
    }
}
