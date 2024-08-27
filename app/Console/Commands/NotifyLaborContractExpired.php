<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\EmployeeContract;
use App\Notifications\LaborContractExpired;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NotifyLaborContractExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-labor-contract-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the labor contract expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Kiểm tra các hđ chính thức sắp hết hạn trước 1 tháng
        $employee_contracts = EmployeeContract::where('contract_type_id', 2)
                                                ->where('status', 'On')
                                                ->whereDate('end_date', Carbon::now()->addDays(30))
                                                ->get();
        // Gửi mail tới nhân viên nhân sự
        $ns_admins = Admin::where('role_id', 4)->get();
        foreach ($employee_contracts as $employee_contract) {
            foreach ($ns_admins as $ns_admin) {
                Notification::route('mail' , $ns_admin->email)->notify(new LaborContractExpired($employee_contract->id));
            }
        }

    }
}
