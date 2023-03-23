<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RawFileExportController extends Controller
{
	public function rawFileView(Request $request)
	{

		if($request->get('startTime')){

			$unit_id = trim($request->get('unit_id'));
			$start = Carbon::parse($request->get('startTime'))->format('Y-m-d H:m');
			$end = Carbon::parse($request->get('endTime'))->format('Y-m-d H:m');


			$dataAPI = 'http://api.wetrustgps.com:7899/api/v1/raw-file/'.$unit_id.'/'.strtotime($start).'/'.strtotime($end);

			$data = file_get_contents($dataAPI);
			$data = json_decode($data,true);


			$headerData=array('ID', 'Unit ID', 'Course', 'Latitude','Longitude','Speed','Acc','Date time');


			$filename= $unit_id.".csv";
			$file_path = public_path().'/uploads/'.$filename;
			$file = fopen($file_path,"w+");
			fputcsv($file, $headerData);
			foreach ($data as $exp_data){
				fputcsv($file,$exp_data);
			}
			fclose($file);

			$headers = ['Content-Type' => 'application/csv'];
			return response()->download($file_path,$filename,$headers );

		}

		$data = [];

		return view('raw-file',compact('data'));
	}
}
