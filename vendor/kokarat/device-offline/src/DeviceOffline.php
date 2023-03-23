<?php

namespace Kokarat\DeviceOffline;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class DeviceOffline extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('device-offline', __DIR__.'/../dist/js/tool.js');
        Nova::style('device-offline', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('device-offline::navigation');
    }
}
