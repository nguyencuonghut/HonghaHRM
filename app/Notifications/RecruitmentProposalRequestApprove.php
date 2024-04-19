<?php

namespace App\Notifications;

use App\Models\RecruitmentProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecruitmentProposalRequestApprove extends Notification implements ShouldQueue
{
    use Queueable;

    protected $proposal_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($proposal_id)
    {
        $this->proposal_id = $proposal_id;
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
        $url = '/admin/recruitment/proposals/' . $this->proposal_id;
        $proposal = RecruitmentProposal::findOrFail($this->proposal_id);
        if ($proposal->company_job->division_id) {
            return (new MailMessage)
            ->subject('Đề nghị duyệt đề xuất tuyển dụng ' . $proposal->company_job->name)
            ->line('Xin mời duyệt đề xuất tuyển dụng vị trí: ' . $proposal->company_job->name)
            ->line('Bộ phận: ' . $proposal->company_job->division->name)
            ->line('Phòng ban: ' . $proposal->company_job->department->name)
            ->action('Duyệt', url($url))
            ->line('Xin cảm ơn!');
        } else {
            return (new MailMessage)
            ->subject('Đề nghị duyệt đề xuất tuyển dụng ' . $proposal->company_job->name)
            ->line('Xin mời duyệt đề xuất tuyển dụng vị trí: ' . $proposal->company_job->name)
            ->line('Phòng ban: ' . $proposal->company_job->department->name)
            ->action('Duyệt', url($url))
            ->line('Xin cảm ơn!');
        }
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
