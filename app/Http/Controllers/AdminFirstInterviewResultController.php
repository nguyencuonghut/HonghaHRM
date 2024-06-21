<?php

namespace App\Http\Controllers;

use App\Models\FirstInterviewResult;
use App\Models\SecondInterviewResult;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AdminFirstInterviewResultController extends Controller
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
            'result' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'result.required' => 'Bạn phải chọn kết quả.',
        ];

        $request->validate($rules,$messages);

        $first_interview_result = new FirstInterviewResult();
        $first_interview_result->proposal_candidate_id = $request->proposal_candidate_id;
        $first_interview_result->interviewer_id = Auth::user()->id;
        $first_interview_result->result = $request->result;
        $first_interview_result->save();

        Alert::toast('Nhập kết quả thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(FirstInterviewResult $firstInterviewResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FirstInterviewResult $firstInterviewResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $proposal_candidate_id)
    {
        $rules = [
            'proposal_candidate_id' => 'required',
            'result' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'result.required' => 'Bạn phải chọn kết quả.',
        ];

        $request->validate($rules,$messages);

        // Do not allow to update when SecondInterviewResult committed.
        $second_interview_result = SecondInterviewResult::where('proposal_candidate_id', $proposal_candidate_id)->first();
        if ($second_interview_result) {
            Alert::toast('Đã có kết quả PV lần 2. Không thể sửa!', 'error', 'top-right');
            return redirect()->back();
        }

        $first_interview_result = FirstInterviewResult::where('proposal_candidate_id', $proposal_candidate_id)->first();
        $first_interview_result->proposal_candidate_id = $request->proposal_candidate_id;
        $first_interview_result->interviewer_id = Auth::user()->id;
        $first_interview_result->result = $request->result;
        $first_interview_result->save();

        Alert::toast('Sửa kết quả thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($proposal_candidate_id)
    {
        // Do not allow to delete when SecondInterviewResult committed.
        $second_interview_result = SecondInterviewResult::where('proposal_candidate_id', $proposal_candidate_id)->first();
        if ($second_interview_result) {
            Alert::toast('Đã có kết quả PV lần 2. Không thể xóa!', 'error', 'top-right');
            return redirect()->back();
        }

        $first_interview_result = FirstInterviewResult::where('proposal_candidate_id', $proposal_candidate_id)->first();
        $first_interview_result->destroy($first_interview_result->id);
        Alert::toast('Xóa kết quả thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
