<?php

namespace App\Notifications;

use App\Models\FirstInterviewInvitation;
use App\Models\ProposalCandidate;
use App\Models\RecruitmentCandidate;
use App\Models\RecruitmentProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FirstInterviewInvitationCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $proposal_candidate_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($proposal_candidate_id)
    {
        $this->proposal_candidate_id = $proposal_candidate_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $proposal_candidate = ProposalCandidate::findOrFail($this->proposal_candidate_id);
        $candidate = RecruitmentCandidate::findOrFail($proposal_candidate->candidate_id);
        $proposal = RecruitmentProposal::findOrFail($proposal_candidate->proposal_id);
        $first_interview_invitation = FirstInterviewInvitation::where('proposal_candidate_id', $proposal_candidate->id)->first();

        return (new MailMessage)
                ->subject('Mời phỏng vấn lần 1 cho vị trí ' . $proposal->company_job->name)
                ->line('Xin mời bạn tham gia phỏng vấn lần 1 cho vị trí: ' . $proposal->company_job->name . '.')
                ->line('Bộ phận: ' . $proposal->company_job->division->name . '.')
                ->line('Phòng ban: ' . $proposal->company_job->department->name . '.')
                ->line('Thời gian: ' . date('d//m/Y', strtotime($first_interview_invitation->interview_time)) . '.')
                ->line('Địa điểm: ' . $first_interview_invitation->interview_location . '.')
                ->line('Người liên hệ: ' . $first_interview_invitation->contact . '.')
                ->line('Xin cảm ơn!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
