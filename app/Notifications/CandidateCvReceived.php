<?php

namespace App\Notifications;

use App\Models\RecruitmentProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CandidateCvReceived extends Notification implements ShouldQueue
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
        $proposal = RecruitmentProposal::findOrFail($this->proposal_id);
        return (new MailMessage)
            ->subject('[Honghafeed] Thông báo đã nhận hồ sơ ứng tuyển cho vị trí ' . $proposal->company_job->name)
            ->line('Chúng tôi đã nhận được hồ sơ ứng tuyển của bạn cho vị trí: ' . $proposal->company_job->name . '.')
            ->line('Cảm ơn bạn đã gửi hồ sơ!')
            ->line('Chúng tôi sẽ liên hệ lại với bạn ngay khi có lịch phỏng vấn.')
            ->line('Đây là mail tự động, bạn vui lòng không phản hồi lại email này.')
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
