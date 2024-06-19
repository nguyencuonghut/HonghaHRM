<?php

namespace App\Notifications;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $admin_id;
    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct($admin_id, $password)
    {
        $this->admin_id = $admin_id;
        $this->password = $password;
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
        $url = '/admin/';
        $admin = Admin::findOrFail($this->admin_id);
        return (new MailMessage)
                    ->subject('Kích hoạt tài khoản quản trị phần mềm Honghafeed HRM ' . $admin->name)
                    ->line('Xin mời kích hoạt tài khoản: ' . $admin->name .  ' (' . $admin->email . ')')
                    ->line('Mật khẩu: ' . $this->password)
                    ->action('Đăng nhập tài khoản của bạn', url($url))
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
