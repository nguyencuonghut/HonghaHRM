<?php

namespace App\Notifications;

use App\Models\RecruitmentPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecruitmentPlanRequestApprove extends Notification implements ShouldQueue
{
    use Queueable;

    protected $plan_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($plan_id)
    {
        $this->plan_id = $plan_id;
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
        $plan = RecruitmentPlan::findOrFail($this->plan_id);
        $url = '/admin/recruitment/proposals/' . $plan->proposal_id;
        if ($plan->proposal->company_job->division_id) {
            return (new MailMessage)
            ->subject('Đề nghị duyệt kế hoạch tuyển dụng ' . $plan->proposal->company_job->name)
            ->line('Xin mời duyệt đề xuất tuyển dụng vị trí: ' . $plan->proposal->company_job->name)
            ->line('Bộ phận: ' . $plan->proposal->company_job->division->name)
            ->line('Phòng ban: ' . $plan->proposal->company_job->department->name)
            ->action('Duyệt', url($url))
            ->line('Xin cảm ơn!');
        } else {
            return (new MailMessage)
            ->subject('Đề nghị duyệt kế hoạch tuyển dụng ' . $plan->proposal->company_job->name)
            ->line('Xin mời duyệt đề xuất tuyển dụng vị trí: ' . $plan->proposal->company_job->name)
            ->line('Phòng ban: ' . $plan->proposal->company_job->department->name)
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
