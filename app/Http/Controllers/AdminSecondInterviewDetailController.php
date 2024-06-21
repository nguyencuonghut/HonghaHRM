<?php

namespace App\Http\Controllers;

use App\Models\SecondInterviewDetail;
use App\Models\SecondInterviewResult;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminSecondInterviewDetailController extends Controller
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
            'content' => 'required',
            'comment' => 'required',
            'score' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'content.required' => 'Bạn phải nhập nội dung',
            'comment.required' => 'Bạn phải nhập đánh giá.',
            'score.required' => 'Bạn phải chọn điểm.',
        ];

        $request->validate($rules,$messages);

        $second_interview_detail = new SecondInterviewDetail();
        $second_interview_detail->proposal_candidate_id = $request->proposal_candidate_id;
        $second_interview_detail->content = $request->content;
        $second_interview_detail->comment = $request->comment;
        $second_interview_detail->score = $request->score;
        $second_interview_detail->save();

        Alert::toast('Nhập dữ liệu thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(SecondInterviewDetail $secondInterviewDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SecondInterviewDetail $secondInterviewDetail)
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
            'content' => 'required',
            'comment' => 'required',
            'score' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'content.required' => 'Bạn phải nhập nội dung',
            'comment.required' => 'Bạn phải nhập đánh giá.',
            'score.required' => 'Bạn phải chọn điểm.',
        ];

        $request->validate($rules,$messages);

        // Do not allow to update if SecondInterview has result
        $second_interview_result = SecondInterviewResult::where('proposal_candidate_id', $request->proposal_candidate_id)->first();
        if ($second_interview_result) {
            Alert::toast('Kết quả PV lần 2 đã duyệt. Không xóa được!', 'error', 'top-right');
            return redirect()->back();
        }

        $second_interview_detail = SecondInterviewDetail::findOrFail($id);
        $second_interview_detail->proposal_candidate_id = $request->proposal_candidate_id;
        $second_interview_detail->content = $request->content;
        $second_interview_detail->comment = $request->comment;
        $second_interview_detail->score = $request->score;
        $second_interview_detail->save();

        Alert::toast('Sửa dữ liệu thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $second_interview_detail = SecondInterviewDetail::findOrFail($id);
        // Do not allow to delete when SecondInterviewResult committed.
        $second_interview_result = SecondInterviewResult::where('proposal_candidate_id', $second_interview_detail->proposal_candidate_id)->first();
        if ($second_interview_result) {
            Alert::toast('Đã có kết quả PV lần 2. Không thể xóa!', 'error', 'top-right');
            return redirect()->back();
        }
        $second_interview_detail->destroy($id);
        Alert::toast('Xóa kết quả thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
