<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Task;
use App\Policies\DepartmentPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Department::class =>DepartmentPolicy::class,
        Employee::class => EmployeePolicy::class,
        Task::class => TaskPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
