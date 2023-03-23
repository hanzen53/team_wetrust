<?php

namespace App\Http\Controllers;

use App\TPIJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TPIController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function openJob()
	{
		$whsCode = DB::select("SELECT * FROM `tpi_whs_code`");
		$jobs = TPIJob::all();
		return view('tpi/open',compact('whsCode','jobs'));
    }

	public function searchData(Request $request)
	{
		//$search = 180609;
		$search = $request->get('search');
		//echo "SELECT * FROM `tpi_area_code` WHERE `area_code` LIKE '%$search%'";
		$areaCode = DB::select("SELECT * FROM `tpi_area_code` WHERE `area_code` LIKE '%$search%' LIMIT 0,10");

		return ['result' => $areaCode];
    }

	public function createJob(Request $request)
	{
		TPIJob::create([
			'car_no' => $request->get('car'),
			'whs_code' => $request->get('whs_code'),
			'area_code' => $request->get('area_code'),
			'dp_no' => 'P'.Carbon::now()->timestamp,
			'dp_date_time' => Carbon::now()->toDateTimeString(),
			'checked_by' => Auth::user()->name,
		]);

		return redirect()->back();
    }


}
