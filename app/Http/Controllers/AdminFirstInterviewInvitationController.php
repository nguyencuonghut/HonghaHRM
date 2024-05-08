<?php

namespace App\Http\Controllers;

use App\Models\FirstInterviewInvitation;
use App\Models\ProposalCandidate;
use App\Models\RecruitmentCandidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\FirstInterviewInvitationCreated;

class AdminFirstInterviewInvitationController extends Controller
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
        return view('admin.recruitment.interview.first_interview_invitation',
                    ['proposal_candidate' => $proposal_candidate]
                    );
    }

    public function feedback($proposal_candidate_id)
    {
        $first_interview_invitation = FirstInterviewInvitation::where('proposal_candidate_id', $proposal_candidate_id)->first();
        return view('admin.recruitment.interview.first_interview_feedback',
                    ['first_interview_invitation' => $first_interview_invitation]
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
        $old_invitations = FirstInterviewInvitation::where('proposal_candidate_id', $request->proposal_candidate_id)->get();
        foreach ($old_invitations as $old_invitation) {
            $old_invitation->destroy($old_invitation->id);
        }

        // Create new invitation
        $first_interview_invitation = new FirstInterviewInvitation();
        $first_interview_invitation->proposal_candidate_id = $request->proposal_candidate_id;
        $first_interview_invitation->interview_time = Carbon::createFromFormat('d/m/Y H:i', $request->interview_time);
        $first_interview_invitation->interview_location = $request->interview_location;
        $first_interview_invitation->contact = $request->contact;
        $first_interview_invitation->status = 'Đã gửi';
        $first_interview_invitation->save();

        // Send email notification to Candidate
        $proposal_candidate = ProposalCandidate::findOrFail($request->proposal_candidate_id);
        $candidate = RecruitmentCandidate::findOrFail($proposal_candidate->candidate_id);
        Notification::route('mail' , $candidate->email)->notify(new FirstInterviewInvitationCreated($proposal_candidate->id));

        Alert::toast('Gửi lời mời thành công!', 'success', 'top-right');
        return redirect()->route('admin.recruitment.proposals.show', $proposal_candidate->proposal_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(FirstInterviewInvitation $firstInterviewInvitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FirstInterviewInvitation $firstInterviewInvitation)
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

        $first_interview_invitation = FirstInterviewInvitation::where('proposal_candidate_id', $proposal_candidate_id)->first();
        $first_interview_invitation->feedback = $request->feedback;
        if ($request->note) {
            $first_interview_invitation->note = $request->note;
        }
        $first_interview_invitation->save();

        $proposal_candidate = ProposalCandidate::findOrFail($request->proposal_candidate_id);
        Alert::toast('Cập nhật phản hồi thành công!', 'success', 'top-right');
        return redirect()->route('admin.recruitment.proposals.show', $proposal_candidate->proposal_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FirstInterviewInvitation $firstInterviewInvitation)
    {
        //
    }
}
