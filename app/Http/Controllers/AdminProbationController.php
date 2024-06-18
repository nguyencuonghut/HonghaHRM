<?php

namespace App\Http\Controllers;

use App\Models\Probation;
use Illuminate\Http\Request;
use App\Models\ProposalCandidateEmployee;
use App\Models\ProposalCandidate;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AdminProbationController extends Controller
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
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id hồ sơ nhân sự không hợp lệ.',
            'start_date.required' => 'Bạn phải nhập ngày bắt đầu.',
            'end_date.required' => 'Bạn phải nhập ngày kết thúc.',
        ];

        $request->validate($rules, $messages);

        // Get the last proposal_id
        $last_proposal_candidate_employee = ProposalCandidateEmployee::where('employee_id', $request->employee_id)
                                                                        ->orderBy('id', 'desc')->latest()->first();
        if ($last_proposal_candidate_employee->count()) {
            $last_proposal_candidate = ProposalCandidate::findOrFail($last_proposal_candidate_employee->proposal_candidate_id);
        } else {
            Alert::toast('Không tìm thấy đề xuất tuyển dụng cho kế hoạch thử việc!', 'error', 'top-right');
            return redirect()->back();
        }

        $probation = new Probation();
        $probation->employee_id = $request->employee_id;
        $probation->proposal_id = $last_proposal_candidate->proposal_id;
        $probation->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $probation->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $probation->creator_id = Auth::user()->id;
        $probation->save();

        Alert::toast('Thêm kế hoạch thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $probation = Probation::findOrFail($id);
        return view('admin.probation.show', ['probation' => $probation]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Probation $probation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $messages = [
            'start_date.required' => 'Bạn phải nhập ngày bắt đầu.',
            'end_date.required' => 'Bạn phải nhập ngày kết thúc.',
        ];

        $request->validate($rules, $messages);

        $probation = Probation::findOrFail($id);
        $probation->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $probation->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $probation->creator_id = Auth::user()->id;
        $probation->save();

        Alert::toast('Sửa kế hoạch thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $probation = Probation::findOrFail($id);

        // Delete all Plans
        foreach ($probation->plans as $plan) {
            $plan->destroy($plan->id);
        }

        // Delete probation
        $probation->destroy($id);

        Alert::toast('Xóa kế hoạch thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function evaluate(Request $request, $id)
    {
        $rules = [
            'result_of_work' => 'required',
            'result_of_attitude' => 'required',
            'result_manager_status' => 'required'
        ];

        $messages = [
            'result_of_work.required' => 'Bạn phải nhập kết quả công việc.',
            'result_of_attitude.required' => 'Bạn phải nhập ý thức, thái độ.',
            'result_manager_status.required' => 'Bạn phải nhập đánh giá.',
        ];

        $request->validate($rules, $messages);

        $probation = Probation::findOrFail($id);
        $probation->result_of_work = $request->result_of_work;
        $probation->result_of_attitude = $request->result_of_attitude;
        $probation->result_manager_status = $request->result_manager_status;
        $probation->save();

        Alert::toast('Đánh giá kết quả thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
