<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateDeviceOnMongodbController extends Controller
{
	public function create()
	{
		//$query = DB::select("SELECT `uniqueid`,`name` FROM `devices_create_on_mongodb-mittare1` where id between 550 and 600");
		//$query = DB::select("SELECT `uniqueid`,`name` FROM `devices_create_on_mongodb-mittare2` where id between 350 and 400");
		$query = DB::select("SELECT `uniqueid`,`name` FROM `devices_create_on_mongodb-mittare3` where id between 150 and 200");

		$user_api_hash = '$2y$10$M4jpQlVD4QToRFGsN5n7x.Clni9W.OMwzO/CII7fz0zcVwck5L3EG';

		foreach ($query as $value){


			//define the data to send to the api
			$postfields = [
				'name' => $value->name,
				'imei' => $value->uniqueid,
				'icon_id' => 59,
				'fuel_measurement_id' => 1,
				'tail_length' => 5,
				'min_moving_speed' => 6,
				'min_fuel_fillings' => 10,
				'min_fuel_thefts' => 10,
				'user_api_hash' => $user_api_hash ,
				'group_id' => 14,
			];

			$json = json_encode($postfields);
			$url = 'http://lite.wetrustgps.com/api/add_device';


			$this->createDevice($json,$url,80);
		}


// 		Create devices on mongodb
//		 foreach ($query as $value){
//			 $device = [
//			 	'device_id' => $value->uniqueid,
//			 	'device_name' => $value->name,
//			 	'is_deleted' => 0,
//				'mittare' => 1
//			 ];
//
//			 $json = json_encode($device);
//			 $url = "http://api.wetrustgps.com:7899/api/devices/create";
//			 $this->createDevice($json,$url,7899);
//		 }

	}

	public function createDevice($json,$url,$port)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => $port,
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 20,
			CURLOPT_TIMEOUT => 600,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Content-Type: application/json",
				"Postman-Token: ac749b2a-d7b9-4576-967b-6d4ea1432ad9"
			),
		));

		$response = utf8_decode(curl_exec($curl));
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
	}

	public function createDeviceOnGPSWOX()
	{

	}
}
