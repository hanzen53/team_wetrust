<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConvertAddressController extends Controller
{


	public function updateAddress()
	{
			$data = 	DB::select("SELECT * FROM raw_to_address WHERE address IS NULL LIMIT 500");

			foreach ($data as $value){
				echo  $value->id.' '.$value->latitude.','.$value->longitude."<br/>";;
				$lat = $value->latitude;

				$lon = $value->longitude;
				$address = $this->getAddress($lat,$lon);
				$address = $address?$address:'';
				echo $address;


				DB::table('raw_to_address')
					->where('id', $value->id)
					->update(['address' => $address]);

			}

			return "Done";
	}

	/**
	 * Author: CodexWorld
	 * Author URI: http://www.codexworld.com
	 * Function Name: getAddress()
	 * $latitude => Latitude.
	 * $longitude => Longitude.
	 * Return =>  Address of the given Latitude and longitude.
	 **/
	public function getAddress($latitude,$longitude){
		if(!empty($latitude) && !empty($longitude)){
			//Send request and receive json data by address
			$geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=true_or_false&language=th&region=TH&key=AIzaSyDtiFk1HJp19sUIyvGVPNjN2E_o9iJtZ28');
			echo $geocodeFromLatLong;
			$output = json_decode($geocodeFromLatLong);
			$status = $output->status;
			//Get address from json data
			$address = ($status=="OK")?$output->results[1]->formatted_address:'';
			//Return address of the given latitude and longitude
			if(!empty($address)){
				return $address;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}
