<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Admin;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public static $permissions = [
        'create-admin' => ['Admin'],
        'create-company-job' => ['Admin', 'Nhân sự'],
        'create-recruitment-method' => ['Admin', 'Nhân sự'],
        'create-recruitment-social-media' => ['Admin', 'Nhân sự'],
        'create-cv-receive-method' => ['Admin', 'Nhân sự'],
        'create-propose' => ['Admin', 'Trưởng đơn vị'],
        'filter-candidate' => ['Admin', 'Nhân sự'],
        'initial-interview' => ['Admin', 'Nhân sự'],
        'create-exams-result' => ['Admin', 'Nhân sự'],
        'create-first-interview-result' => ['Admin', 'Trưởng đơn vị'],
        'create-second-interview-invitation' => ['Admin', 'Nhân sự'],
        'create-second-interview-result' => ['Admin', 'Ban lãnh đạo'],
        'create-offer' => ['Admin', 'Nhân sự'],
        'approve-offer' => ['Admin', 'Ban lãnh đạo'],
        'create-company-job' => ['Admin', 'Nhân sự'],
        'view-salary' => ['Admin', 'Nhân sự'],
        'create-document' => ['Admin', 'Nhân sự'],
        'create-probation' => ['Admin', 'Trưởng đơn vị'],
        'review-probation' => ['Admin', 'Nhân sự'],
        'approve-probation' => ['Admin', 'Ban lãnh đạo'],
    ];

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(
            function (Admin $admin, $ability) {
                if ($admin->role->name === 'Admin') {
                    return true;
                }
            }
        );

        foreach (self::$permissions as $action => $roles) {
            Gate::define(
                $action,
                function (Admin $admin) use ($roles) {
                    if (in_array($admin->role->name, $roles)) {
                        return true;
                    }
                }
            );
        }
    }
}
