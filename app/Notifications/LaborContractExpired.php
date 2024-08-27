<?php

namespace App\Notifications;

use App\Models\EmployeeContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LaborContractExpired extends Notification implements ShouldQueue
{
    use Queueable;
    protected $contract_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($contract_id)
    {
        $this->contract_id = $contract_id;
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
        $employee_contract = EmployeeContract::findOrFail($this->contract_id);
        return (new MailMessage)
                    ->subject('Cảnh báo HĐLĐ số ' . $employee_contract->code . ' ' . $employee_contract->employee->name . ' sắp hết hạn vào ngày ' . date('d/m/Y', strtotime($employee_contract->end_date)))
                    ->line('Hợp đồng sau đây sắp hết hạn. ')
                    ->line('- Số: ' . $employee_contract->code)
                    ->line('- Nhân sự: ' . $employee_contract->employee->code . ' - ' . $employee_contract->employee->name)
                    ->line('- Vị trí: ' . $employee_contract->company_job->name)
                    ->line('- Phòng ban: ' . $employee_contract->company_job->department->name)
                    ->line('- Ngày bắt đầu: ' . date('d/m/Y', strtotime($employee_contract->start_date)))
                    ->line('- Ngày kết thúc: ' . date('d/m/Y', strtotime($employee_contract->end_date)))
                    ->line('Xin mời bạn làm các thủ tục gia hạn, tái ký.')
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
