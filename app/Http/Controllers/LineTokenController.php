<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LineTokenController extends Controller
{
	public function addLineToken()
	{
		$users = User::all();
		return view('user-management/add-line-token',compact('users'));
    }

	public function sendData(Request $request)
	{
		//return $request->all();

		$user = $request->get('user');
		$line_token = $request->get('line_token');

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "7899",
			CURLOPT_URL => "http://api.wetrustgps.com:7899/api/assign-device-to-user/$user",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n    \"line_token\" : \"$line_token\"\n}\n",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"postman-token: 6ab8cffb-4ce4-b97b-7d52-88a82c255060"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}

		Session::flash('success',"");

		return redirect()->back();
    }
}
