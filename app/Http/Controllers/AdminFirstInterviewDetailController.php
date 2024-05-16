<?php

namespace App\Http\Controllers;

use App\Models\FirstInterviewDetail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class AdminFirstInterviewDetailController extends Controller
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

        $first_interview_detail = new FirstInterviewDetail();
        $first_interview_detail->proposal_candidate_id = $request->proposal_candidate_id;
        $first_interview_detail->content = $request->content;
        $first_interview_detail->comment = $request->comment;
        $first_interview_detail->score = $request->score;
        $first_interview_detail->save();

        Alert::toast('Nhập dữ liệu thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(FirstInterviewDetail $firstInterviewDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FirstInterviewDetail $firstInterviewDetail)
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

        $first_interview_detail = FirstInterviewDetail::findOrFail($id);
        $first_interview_detail->proposal_candidate_id = $request->proposal_candidate_id;
        $first_interview_detail->content = $request->content;
        $first_interview_detail->comment = $request->comment;
        $first_interview_detail->score = $request->score;
        $first_interview_detail->save();

        Alert::toast('Sửa dữ liệu thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $first_interview_detail = FirstInterviewDetail::findOrFail($id);
        $first_interview_detail->destroy($id);
        Alert::toast('Xóa kết quả thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
