<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueController extends Controller
{
    public function deviceOffline()
    {
        return view('vue/devices-offline');
    }

	public function deviceStatus()
	{
		return view('vue/devices-status');
    }

	public function vueDebug()
	{
		return view('vue/example');
    }
}
