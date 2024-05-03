<?php

namespace App\Http\Controllers;

use App\Models\ProposalCandidateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;

class AdminProposalCandidateFilterController extends Controller
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
            'work_location' => 'required',
            'salary' => 'required',
            'result' => 'required',
            'proposal_candidate_id' => 'required',
        ];
        $messages = [
            'work_location.required' => 'Bạn phải nhập nơi làm việc.',
            'salary.required' => 'Bạn phải nhập mức lương.',
            'result.required' => 'Bạn phải chọn kết quả.',
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
        ];

        $request->validate($rules,$messages);

        $proposal_candidate_filter = new ProposalCandidateFilter();
        $proposal_candidate_filter->proposal_candidate_id = $request->proposal_candidate_id;
        $proposal_candidate_filter->work_location = $request->work_location;
        $proposal_candidate_filter->salary = $request->salary;
        $proposal_candidate_filter->result = $request->result;
        $proposal_candidate_filter->note = $request->filter_note;
        $proposal_candidate_filter->save();

        Alert::toast('Lọc ứng viên thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProposalCandidateFilter $proposalCandidateFilter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProposalCandidateFilter $proposalCandidateFilter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'work_location' => 'required',
            'salary' => 'required',
            'result' => 'required',
            'proposal_candidate_id' => 'required',
        ];
        $messages = [
            'work_location.required' => 'Bạn phải nhập nơi làm việc.',
            'salary.required' => 'Bạn phải nhập mức lương.',
            'result.required' => 'Bạn phải chọn kết quả.',
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
        ];

        $request->validate($rules,$messages);

        $proposal_candidate_filter = ProposalCandidateFilter::findOrFail($id);
        $proposal_candidate_filter->proposal_candidate_id = $request->proposal_candidate_id;
        $proposal_candidate_filter->work_location = $request->work_location;
        $proposal_candidate_filter->salary = $request->salary;
        $proposal_candidate_filter->result = $request->result;
        $proposal_candidate_filter->note = $request->filter_note;
        $proposal_candidate_filter->save();

        Alert::toast('Lọc ứng viên thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProposalCandidateFilter $proposalCandidateFilter)
    {
        //
    }
}
