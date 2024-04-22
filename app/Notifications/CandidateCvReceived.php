<?php

namespace App\Notifications;

use App\Models\RecruitmentCandidate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CandidateCvReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $candidate_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($candidate_id)
    {
        $this->candidate_id = $candidate_id;
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
        $candidate = RecruitmentCandidate::findOrFail($this->candidate_id);

        return (new MailMessage)
            ->subject('[Honghafeed] Thông báo đã nhận hồ sơ ứng tuyển cho vị trí ' . $candidate->proposal->company_job->name)
            ->line('Chúng tôi đã nhận được hồ sơ ứng tuyển của bạn cho vị trí: ' . $candidate->proposal->company_job->name . '.')
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
