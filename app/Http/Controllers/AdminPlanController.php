<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Probation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminPlanController extends Controller
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
            'probation_id' => 'required',
            'work_title' => 'required',
            'work_requirement' => 'required',
            'work_deadline' => 'required',
            'instructor' => 'required',
        ];

        $messages = [
            'probation_id.required' => 'Số id thử việc không hợp lệ.',
            'work_title.required' => 'Bạn phải nhập nội dung công việc.',
            'work_requirement.required' => 'Bạn phải nhập yêu cầu.',
            'work_deadline.required' => 'Bạn phải nhập deadline.',
            'instructor.required' => 'Bạn phải nhập người hướng dẫn.',
        ];

        $request->validate($rules, $messages);

        $plan = new Plan();
        $plan->probation_id = $request->probation_id;
        $plan->work_title = $request->work_title;
        $plan->work_requirement = $request->work_requirement;
        $plan->work_deadline = Carbon::createFromFormat('d/m/Y', $request->work_deadline);
        if ($request->instructor) {
            $plan->instructor = $request->instructor;
        }
        $plan->save();

        Alert::toast('Thêm chi tiết thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);

        // Check condition before edit
        if ($plan->probation->result_manager_status) {
            Alert::toast('Thử việc đã được QL đánh giá. Bạn không thể sửa!', 'error', 'top-right');
            return redirect()->back();
        }
        return view('admin.plan.edit', ['plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'work_title' => 'required',
            'work_requirement' => 'required',
            'work_deadline' => 'required',
        ];

        $messages = [
            'work_title.required' => 'Bạn phải nhập nội dung công việc.',
            'work_requirement.required' => 'Bạn phải nhập yêu cầu.',
            'work_deadline.required' => 'Bạn phải nhập deadline.',
        ];

        $request->validate($rules, $messages);

        $plan = Plan::findOrFail($id);
        // Check condition before edit
        if ($plan->probation->result_manager_status) {
            Alert::toast('Thử việc đã được QL đánh giá. Bạn không thể sửa!', 'error', 'top-right');
            return redirect()->back();
        }

        $plan->work_title = $request->work_title;
        $plan->work_requirement = $request->work_requirement;
        $plan->work_deadline = Carbon::createFromFormat('d/m/Y', $request->work_deadline);
        if ($request->instructor) {
            $plan->instructor = $request->instructor;
        }
        if ($request->work_result) {
            $plan->work_result = $request->work_result;
        }
        $plan->save();

        $probation = Probation::findOrFail($plan->probation_id);
        Alert::toast('Sửa chi tiết thử việc thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.probations.show', $probation->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        // Check condition before edit
        if ($plan->probation->result_manager_status) {
            Alert::toast('Thử việc đã được QL đánh giá. Bạn không thể sửa!', 'error', 'top-right');
            return redirect()->back();
        }
        $plan->destroy($id);

        Alert::toast('Xóa chi tiết thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
