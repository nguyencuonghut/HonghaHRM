<?php

namespace App\Http\Controllers;

use App\Models\RecruitmentCandidate;
use App\Models\RecruitmentProposal;
use App\Models\ProposalCandidate;
use Illuminate\Http\Request;
use App\Notifications\CandidateCvReceived;
use Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminRecruitmentCandidateController extends Controller
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
            'name' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'cccd' => 'required',
            'issued_date' => 'required',
            'issued_by' => 'required',
            'gender' => 'required',
            'commune_id' => 'required',
            'cv_file' => 'required',
            'cv_receive_method_id' => 'required',
            'batch' => 'required',
        ];
        $messages = [
            'proposal_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'name.required' => 'Bạn phải nhập tên.',
            'email.required' => 'Bạn phải nhập địa chỉ email.',
            'email.email' => 'Email sai định dạng.',
            'email.max' => 'Email dài quá 255 ký tự.',
            'phone.required' => 'Bạn phải số điện thoại.',
            'date_of_birth.required' => 'Bạn phải nhập ngày sinh.',
            'cccd.required' => 'Bạn phải nhập số CCCD.',
            'issued_date.required' => 'Bạn phải nhập ngày cấp.',
            'issued_by.required' => 'Bạn phải nhập nơi cấp.',
            'gender.required' => 'Bạn phải chọn giới tính.',
            'commune_id.required' => 'Bạn phải chọn Xã Phường.',
            'cv_file.required' => 'Bạn phải chọn file CV.',
            'cv_receive_method_id.required' => 'Bạn phải chọn cách nhận CV.',
            'batch.required' => 'Bạn phải chọn đợt.',
        ];
        $request->validate($rules,$messages);

        $candidate = new RecruitmentCandidate();
        $candidate->name = $request->name;
        $candidate->email = $request->email;
        $candidate->phone = $request->phone;
        $candidate->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
        $candidate->cccd = $request->cccd;
        $candidate->issued_date = Carbon::createFromFormat('d/m/Y', $request->issued_date);
        $candidate->issued_by = $request->issued_by;
        $candidate->gender = $request->gender;
        $candidate->commune_id = $request->commune_id;
        $candidate->creator_id = Auth::user()->id;
        $candidate->save();

        // Create ProposalCandidate
        $proposal_candidate = new ProposalCandidate();
        $proposal_candidate->proposal_id = $request->proposal_id;
        $proposal_candidate->candidate_id = $candidate->id;
        if ($request->hasFile('cv_file')) {
            $path = 'dist/cv';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('cv_file');
            $name = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $proposal_candidate->cv_file = $path . '/' . $name;
        }
        $proposal_candidate->batch = $request->batch;
        $proposal_candidate->cv_receive_method_id = $request->cv_receive_method_id;
        $proposal_candidate->creator_id = Auth::user()->id;
        $proposal_candidate->save();

        // Send password to candidate's email
        Notification::route('mail' , $candidate->email)->notify(new CandidateCvReceived($proposal_candidate->proposal_id));

        Alert::toast('Thêm ứng viên mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        //
    }
}
