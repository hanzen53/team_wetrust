<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unkonwOwner = DB::select("SELECT * FROM device_stock WHERE `agent_use` IS NOT NULL AND `customer_id` IS NULL");
        $tmp_device_un_use = DB::table('tmp_device_un_use')->count();
        $dlt_customer = DB::table('dlt_customer')->where('confirm',0)->count();
        $device_canceled = DB::table('device_cancel')->where('confirm',0)->count();


     
        return view('home',compact('unkonwOwner','tmp_device_un_use','dlt_customer','device_canceled'));
    }
}
