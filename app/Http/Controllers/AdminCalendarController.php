<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\FirstInterviewInvitation;
use App\Models\SecondInterviewInvitation;
use App\Models\ProposalCandidate;
use App\Models\RecruitmentProposal;

class AdminCalendarController extends Controller
{
    public function index()
    {
        $events = [];

        // First interview invitations
        $first_interview_invitations = FirstInterviewInvitation::all();
        foreach($first_interview_invitations as $first_interview_invitation){
            $hour = Carbon::parse($first_interview_invitation->interview_time)->hour;
            $minute = Carbon::parse($first_interview_invitation->interview_time)->minute;

            $proposal_candidate = ProposalCandidate::findOrFail($first_interview_invitation->proposal_candidate_id);
            $proposal = RecruitmentProposal::findOrFail($proposal_candidate->proposal_id);

            $background_color = '#00a65a'; //green
            $border_color = '#00a65a'; //green
            $event = [
                "title" => 'PV lần 1 - ' . $proposal->company_job->name,
                "start" => $first_interview_invitation->interview_time,
                "allDay" => false,
                "backgroundColor" => $background_color,
                "borderColor" => $border_color,
            ];
            array_push($events, $event);
        }

        // Second interview invitations
        $second_interview_invitations = SecondInterviewInvitation::all();
        foreach($second_interview_invitations as $second_interview_invitation){
            $hour = Carbon::parse($second_interview_invitation->interview_time)->hour;
            $minute = Carbon::parse($second_interview_invitation->interview_time)->minute;

            $proposal_candidate = ProposalCandidate::findOrFail($second_interview_invitation->proposal_candidate_id);
            $proposal = RecruitmentProposal::findOrFail($proposal_candidate->proposal_id);

            $background_color = '#00a65a'; //green
            $border_color = '#00a65a'; //green
            $event = [
                "title" => 'PV lần 2 - ' . $proposal->company_job->name,
                "start" => $second_interview_invitation->interview_time,
                "allDay" => false,
                "backgroundColor" => $background_color,
                "borderColor" => $border_color,
            ];
            array_push($events, $event);
        }
        return view('admin.calendar.index', ['events' => $events]);
    }
}
