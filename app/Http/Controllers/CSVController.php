<?php

namespace App\Http\Controllers;

use App\Device;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CSVController extends Controller
{
	public function index()
	{
		$userDeviceQuery = DB::select('SELECT user_id,`device_id`,`status` FROM `device_user`');

		$data = [];
		foreach ($userDeviceQuery as $value){
			$device = Device::find($value->device_id);
			$user = User::find($value->user_id);

			$data[] = $device->name.','.$device->uniqueId.','.$device->chassis_no.','.$user->email.','.$user->name;
		}

		return $data;
	}

	public function generateCSV(Request $request)
	{

//		return $dateRange = $request->get('endTime');
		$dateRange = $request->get('daterange');

		$dateRange = explode('-',$dateRange);

		$start = trim($dateRange[0]);
		$end = trim($dateRange[1]);

		if($start == $end){
			$start = Carbon::today();
			$end = Carbon::now();
		}

		$unit_id = $request->get('unit_id');
		$startTime = Carbon::parse($start)->format('Y-m-d\TH:i');
		$endTime = Carbon::parse($end)->format('Y-m-d\TH:i');

		try {
			$json_filename = 'http://api.wetrustgps.com:7899/api/v1/raw-file/' . $unit_id . '/' . $startTime . '/' . $endTime;
			$csv_filename = $unit_id . '_' . $startTime . '-' . $endTime . '.csv';
			$this->jsonToCSV($json_filename, $csv_filename);
			return response()->download($csv_filename);
		}catch (Exception $e){
			return redirect()->back()->withInput(Input::all());
		}
	}


	public function jsonToCSV($jfilename, $cfilename)
	{
		if (($json = file_get_contents($jfilename)) == false) return('Error reading json file...');

		$data = json_decode($json, true);
		$fp = fopen($cfilename, 'w');
		$header = false;
		foreach ($data as $row)
		{
			if (empty($header))
			{
				$header = array_keys($row);
				fputcsv($fp, $header);
				$header = array_flip($header);
			}
			fputcsv($fp, array_merge($header, $row));
		}
		fclose($fp);
		return;
	}
}
