<?php

namespace App\Providers;

use App\User;
use Laravel\Nova\Nova;
use Kokarat\RawData\RawData;
use Laravel\Nova\Cards\Help;
use App\Nova\Metrics\CarCount;
use App\Nova\Metrics\UserCount;
use App\Nova\Metrics\StockCount;
use Kokarat\ImeiStatus\ImeiStatus;
use App\Nova\Metrics\CustomerCount;
use App\Observers\EmployeeObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Nova\Metrics\StockUsedStatus;
use App\Nova\Metrics\CustomerCountTrend;
use Kokarat\DeviceOffline\DeviceOffline;
use Kokarat\DltMasterFile\DltMasterFile;
use Laravel\Nova\NovaApplicationServiceProvider;
use Kokarat\Thaiaddress\Thaiaddress;

class NovaServiceProvider extends NovaApplicationServiceProvider
{


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::serving(function () {
           // User::observe(EmployeeObserver::class);
        });

    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'i@kokarat.me'
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            //new Help,
            //new UserCount,
            new StockCount,
            new StockUsedStatus,
            new CarCount,
           (new CustomerCountTrend)->width('2/3'),
            new CustomerCount,
            // (new Thaiaddress())->width('full'),
           
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {

        return [

            new DltMasterFile(),
            new DeviceOffline(),
            new ImeiStatus(),
            // new RawData(),


            // (new \Cloudstudio\ResourceGenerator\ResourceGenerator())->canSee(function ($request){
            //     $user = Auth::user();
            //     if($user->email == 'dev@wetrustgps.com'){
            //         return true;
            //     }else{
            //         return false;
            //     }
            // }),
            // (new \Cendekia\SettingTool\SettingTool)->canSee(function ($request){
            //     $user = Auth::user();
            //     if($user->email == 'dev@wetrustgps.com'){
            //         return true;
            //     }else{
            //         return false;
            //     }
            // }),


        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
