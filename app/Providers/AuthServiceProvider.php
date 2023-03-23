<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\DeviceStock' => 'App\Policies\StockPolicy',
        'App\Device' => 'App\Policies\DevicesPolicy',
        'App\DLTCar' => 'App\Policies\CarPolicy',
        'App\DLTCustomer' => 'App\Policies\CustomersPolicy',
        'App\User' => 'App\Policies\UsersPolicy',
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
