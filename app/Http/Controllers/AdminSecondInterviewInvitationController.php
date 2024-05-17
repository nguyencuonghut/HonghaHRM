<?php

namespace App\Http\Controllers;

use App\Models\SecondInterviewInvitation;
use App\Models\ProposalCandidate;
use App\Models\RecruitmentCandidate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SecondInterviewInvitationCreated;

class AdminSecondInterviewInvitationController extends Controller
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


    public function add($proposal_candidate_id)
    {
        $proposal_candidate = ProposalCandidate::findOrFail($proposal_candidate_id);
        return view('admin.recruitment.interview.second_interview_invitation',
                    ['proposal_candidate' => $proposal_candidate]
                    );
    }

    public function feedback($proposal_candidate_id)
    {
        $second_interview_invitation = SecondInterviewInvitation::where('proposal_candidate_id', $proposal_candidate_id)->first();
        return view('admin.recruitment.interview.second_interview_feedback',
                    ['second_interview_invitation' => $second_interview_invitation]
                    );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'proposal_candidate_id' => 'required',
            'interview_time' => 'required',
            'interview_location' => 'required',
            'contact' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'interview_time.required' => 'Bạn phải nhập thời gian.',
            'interview_location.required' => 'Bạn phải nhập địa điểm.',
            'contact.required' => 'Bạn phải nhập người liên hệ.',
        ];
        $request->validate($rules,$messages);

        // Delete all previous invitation
        $old_invitations = SecondInterviewInvitation::where('proposal_candidate_id', $request->proposal_candidate_id)->get();
        foreach ($old_invitations as $old_invitation) {
            $old_invitation->destroy($old_invitation->id);
        }

        // Create new invitation
        $second_interview_invitation = new SecondInterviewInvitation();
        $second_interview_invitation->proposal_candidate_id = $request->proposal_candidate_id;
        $second_interview_invitation->interview_time = Carbon::createFromFormat('d/m/Y H:i', $request->interview_time);
        $second_interview_invitation->interview_location = $request->interview_location;
        $second_interview_invitation->contact = $request->contact;
        $second_interview_invitation->status = 'Đã gửi';
        $second_interview_invitation->save();

        // Send email notification to Candidate
        $proposal_candidate = ProposalCandidate::findOrFail($request->proposal_candidate_id);
        $candidate = RecruitmentCandidate::findOrFail($proposal_candidate->candidate_id);
        Notification::route('mail' , $candidate->email)->notify(new SecondInterviewInvitationCreated($proposal_candidate->id));

        Alert::toast('Gửi lời mời thành công!', 'success', 'top-right');
        return redirect()->route('admin.recruitment.proposals.show', $proposal_candidate->proposal_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(SecondInterviewInvitation $secondInterviewInvitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SecondInterviewInvitation $secondInterviewInvitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $proposal_candidate_id)
    {
        $rules = [
            'feedback' => 'required',
        ];
        $messages = [
            'feedback.required' => 'Bạn phải chọn phản hồi.',
        ];
        $request->validate($rules,$messages);

        $second_interview_invitation = SecondInterviewInvitation::where('proposal_candidate_id', $proposal_candidate_id)->first();
        $second_interview_invitation->feedback = $request->feedback;
        if ($request->note) {
            $second_interview_invitation->note = $request->note;
        } else {
            $second_interview_invitation->note = null;
        }
        $second_interview_invitation->save();

        $proposal_candidate = ProposalCandidate::findOrFail($request->proposal_candidate_id);
        Alert::toast('Cập nhật phản hồi thành công!', 'success', 'top-right');
        return redirect()->route('admin.recruitment.proposals.show', $proposal_candidate->proposal_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SecondInterviewInvitation $secondInterviewInvitation)
    {
        //
    }
}
