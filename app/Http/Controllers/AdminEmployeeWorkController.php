<?php

namespace App\Http\Controllers;

use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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

        // Edit EmployeeWork
        $employee_work = EmployeeWork::findOrFail($id);
        $employee_work->employee_id = $request->employee_id;
        $employee_work->company_job_id = $request->company_job_id;
        $employee_work->start_date = Carbon::createFromFormat('d/m/Y', $request->s_date);
        $employee_work->status = 'On';
        $employee_work->save();

        Alert::toast('Sửa quá trình làm việc mới thành công!', 'success', 'top-right');
        return redirect()->back();
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
}
