<?php

namespace App\Http\Controllers;

use App\Models\ProposalCandidate;
use App\Models\ProposalCandidateFilter;
use App\Models\RecruitmentCandidate;
use App\Models\CandidateSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\CandidateCvReceived;

class AdminProposalCandidateController extends Controller
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
            'proposal_id' => 'required',
            'candidate_id' => 'required',
            'cv_file' => 'required',
            'cv_receive_method_id' => 'required',
            'batch' => 'required',
        ];
        $messages = [
            'proposal_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'candidate_id.required' => 'Bạn phải chọn tên ứng viên.',
            'cv_file.required' => 'Bạn phải chọn file CV.',
            'cv_receive_method_id.required' => 'Bạn phải chọn cách nhận CV.',
            'batch.required' => 'Bạn phải chọn đợt.',
        ];

        $request->validate($rules,$messages);

        $proposal_candidate = new ProposalCandidate();
        $proposal_candidate->proposal_id = $request->proposal_id;
        $proposal_candidate->candidate_id = $request->candidate_id;
        if ($request->hasFile('cv_file')) {
            $path = 'dist/cv';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('cv_file');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $proposal_candidate->cv_file = $path . '/' . $name;
        }
        $proposal_candidate->batch = $request->batch;
        $proposal_candidate->cv_receive_method_id = $request->cv_receive_method_id;
        $proposal_candidate->creator_id = Auth::user()->id;
        $proposal_candidate->save();

        // Send notification to candidate's email
        $candidate = RecruitmentCandidate::findOrFail($request->candidate_id);
        Notification::route('mail' , $candidate->email)->notify(new CandidateCvReceived($request->proposal_id));

        Alert::toast('Thêm ứng viên mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'proposal_id' => 'required',
            'candidate_id' => 'required',
            'cv_receive_method_id' => 'required',
            'batch' => 'required',
        ];
        $messages = [
            'proposal_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'candidate_id.required' => 'Bạn phải chọn tên ứng viên.',
            'cv_receive_method_id.required' => 'Bạn phải chọn cách nhận CV.',
            'batch.required' => 'Bạn phải chọn đợt.',
        ];
        $request->validate($rules,$messages);

        $proposal_candidate = ProposalCandidate::findOrFail($id);
        // Do not allow to edit when Candidate is filtered
        $proposal_candidate_filter = ProposalCandidateFilter::where('proposal_candidate_id', $proposal_candidate->id)->first();
        if ($proposal_candidate_filter
            && $proposal_candidate_filter->result) {
            Alert::toast('Ứng viên đã lọc hồ sơ. Không thể sửa!', 'error', 'top-right');
            return redirect()->back();
        }
        $proposal_candidate->proposal_id = $request->proposal_id;
        $proposal_candidate->candidate_id = $request->candidate_id;
        if ($request->hasFile('cv_file')) {
            $path = 'dist/cv';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('cv_file');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $proposal_candidate->cv_file = $path . '/' . $name;
        }
        $proposal_candidate->batch = $request->batch;
        $proposal_candidate->cv_receive_method_id = $request->cv_receive_method_id;
        $proposal_candidate->creator_id = Auth::user()->id;
        $proposal_candidate->save();

        // Send notification to candidate's email
        $candidate = RecruitmentCandidate::findOrFail($request->candidate_id);
        Notification::route('mail' , $candidate->email)->notify(new CandidateCvReceived($request->proposal_id));

        Alert::toast('Sửa ứng viên mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proposal_candidate = ProposalCandidate::findOrFail($id);
        // Do not allow to destroy when Candidate is filtered
        $proposal_candidate_filter = ProposalCandidateFilter::where('proposal_candidate_id', $proposal_candidate->id)->first();
        if ($proposal_candidate_filter
            && $proposal_candidate_filter->result) {
            Alert::toast('Ứng viên đã lọc hồ sơ. Không thể xóa!', 'error', 'top-right');
            return redirect()->back();
        }
        $proposal_candidate->destroy($id);
        Alert::toast('Xóa ứng viên thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
