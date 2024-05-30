<?php

namespace App\Http\Controllers;

use App\Models\InitialInterview;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AdminInitialInterviewController extends Controller
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
            'proposal_candidate_id' => 'required',
            'health_score' => 'required',
            'attitude_score' => 'required',
            'stability_score' => 'required',
            'result' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'health_score.required' => 'Bạn phải chọn điểm sức khỏe',
            'attitude_score.required' => 'Bạn phải chọn điểm thái độ.',
            'stability_score.required' => 'Bạn phải chọn điểm ổn định công việc.',
            'result.required' => 'Bạn phải chọn kết quả.',
        ];

        $request->validate($rules,$messages);

        $initial_interview = new InitialInterview();
        $initial_interview->proposal_candidate_id = $request->proposal_candidate_id;
        $initial_interview->health_score = $request->health_score;
        $initial_interview->attitude_score = $request->attitude_score;
        $initial_interview->stability_score = $request->stability_score;
        $initial_interview->interviewer_id = Auth::user()->id;
        $initial_interview->result = $request->result;
        if ($request->health_comment) {
            $initial_interview->health_comment = $request->health_comment;
        }
        if ($request->attitude_comment) {
            $initial_interview->attitude_comment = $request->attitude_comment;
        }
        if ($request->stability_comment) {
            $initial_interview->stability_comment = $request->stability_comment;
        }
        $initial_interview->total_score = $request->health_score + $request->attitude_score + $request->stability_score;
        $initial_interview->save();

        Alert::toast('Nhập kết quả phỏng vấn sơ bộ thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(InitialInterview $initialInterview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InitialInterview $initialInterview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'proposal_candidate_id' => 'required',
            'health_score' => 'required',
            'attitude_score' => 'required',
            'stability_score' => 'required',
            'result' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'health_score.required' => 'Bạn phải chọn điểm sức khỏe',
            'attitude_score.required' => 'Bạn phải chọn điểm thái độ.',
            'stability_score.required' => 'Bạn phải chọn điểm ổn định công việc.',
            'result.required' => 'Bạn phải chọn kết quả.',
        ];

        $request->validate($rules,$messages);

        $initial_interview = InitialInterview::where('proposal_candidate_id', $request->proposal_candidate_id)->first();
        $initial_interview->proposal_candidate_id = $request->proposal_candidate_id;
        $initial_interview->health_score = $request->health_score;
        $initial_interview->attitude_score = $request->attitude_score;
        $initial_interview->stability_score = $request->stability_score;
        $initial_interview->interviewer_id = Auth::user()->id;
        $initial_interview->result = $request->result;
        if ($request->health_comment) {
            $initial_interview->health_comment = $request->health_comment;
        }
        if ($request->attitude_comment) {
            $initial_interview->attitude_comment = $request->attitude_comment;
        }
        if ($request->stability_comment) {
            $initial_interview->stability_comment = $request->stability_comment;
        }
        $initial_interview->total_score = $request->health_score + $request->attitude_score + $request->stability_score;
        $initial_interview->save();

        Alert::toast('Sửa kết quả phỏng vấn sơ bộ thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($proposal_candidate_id)
    {
        $initial_interview = InitialInterview::where('proposal_candidate_id', $proposal_candidate_id)->first();
        $initial_interview->destroy($initial_interview->id);
        Alert::toast('Xóa kết quả phỏng vấn sơ bộ thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
