<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminExaminationController extends Controller
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
            'standard_score' => 'required',
            'candidate_score' => 'required',
            'result' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'standard_score.required' => 'Bạn phải nhập điểm chuẩn',
            'candidate_score.required' => 'Bạn phải nhập điểm thi.',
            'result.required' => 'Bạn phải chọn kết quả.',
        ];

        $request->validate($rules,$messages);

        $exam = new Examination();
        $exam->proposal_candidate_id = $request->proposal_candidate_id;
        $exam->standard_score = $request->standard_score;
        $exam->candidate_score = $request->candidate_score;
        $exam->result = $request->result;
        $exam->save();

        Alert::toast('Nhập kết quả thi tuyển thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Examination $examination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Examination $examination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Examination $examination)
    {
        $rules = [
            'proposal_candidate_id' => 'required',
            'standard_score' => 'required',
            'candidate_score' => 'required',
            'result' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'standard_score.required' => 'Bạn phải nhập điểm chuẩn',
            'candidate_score.required' => 'Bạn phải nhập điểm thi.',
            'result.required' => 'Bạn phải chọn kết quả.',
        ];

        $request->validate($rules,$messages);

        $exam = Examination::where('proposal_candidate_id', $request->proposal_candidate_id)->first();
        $exam->proposal_candidate_id = $request->proposal_candidate_id;
        $exam->standard_score = $request->standard_score;
        $exam->candidate_score = $request->candidate_score;
        $exam->result = $request->result;
        $exam->save();

        Alert::toast('Sửa kết quả thi tuyển thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($proposal_candidate_id)
    {
        $exam = Examination::where('proposal_candidate_id', $proposal_candidate_id)->first();
        $exam->destroy($exam->id);
        Alert::toast('Xóa kết quả thi tuyển thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
