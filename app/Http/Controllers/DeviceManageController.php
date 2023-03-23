<?php

namespace App\Http\Controllers;

use App\DeviceStock;
use App\DLTCar;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\String_;

class DeviceManageController extends Controller
{
    public function deviceStatus(Request $request)
    {
        //return $request->get_raw;

        $data = [];

        if (isset($request->imei)) {
            $data = file_get_contents('http://api.wetrustgps.com:7899/api/devices/show/' . $request->imei);
            $data = json_decode($data, true);

            return view('devices/device-status', compact('data'));
        } else {
            return view('devices/device-status', compact('data'));
        }

    }

    public function forwardWox()
    {
        return view('devices/forward2wox');
    }

    public function forwardWoxPOST(Request $request)
    {
        $imeiArr = explode("\n", $request->imei);

        $imeiJson = json_encode(['imei' => $imeiArr]);

        $ch = curl_init('http://api.wetrustgps.com:7899/api/set-device-to-wox');
        //$ch = curl_init('http://localhost:7899/api/set-device-to-wox');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $imeiJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($imeiJson))
        );

        $result = curl_exec($ch);

        Session::flash('success', 'Updated');

        return redirect()->back();
    }

    public function releaseIMEI()
    {
        return view('devices/release');
    }

    public function releaseIMEIPOST(Request $request)
    {
        $request->validate([
            'imei' => 'required',
            'note' => 'required',
        ]);

        $imeiFind = trim($request->get('imei'));

        $imei = DeviceStock::where('unit_id', '=', $imeiFind)->first();
        $imei->used = 0;
        $imei->agent_use = null;
        $imei->agent_name = null;
        $imei->release_by = Auth::user()->name;
        $imei->release_note = $request->get('note');

        $imei->save();

        return redirect()->back();

    }

    public function deviceUsed(Request $request)
    {

    }

    public function updateAssignCar($user_id, $user_login_id)
    {
        //return $user_login_id;

    //    $test1 =  $this->findIMEIID('359857082988858');
    //    $test2 =  $this->findIMEIID('359857082991092');

    //   return  $imeiID = [$test1,$test2];

        $carsFind = DLTCar::where('owner_id', '=', $user_id)->get();

        $devices = [];
        if (count($carsFind) == 1) {
            $devices['devices'][] = $carsFind[0]->gps_stock[0]->unit_id;

        } else {
            foreach ($carsFind as $item) {
                if ($item->gps_stock()->exists()) {
                    $devices['devices'][] = $item->gps_stock[0]->unit_id;
                }
            }
        }

        // return $devices;
        $json = json_encode($devices);

        $this->curlSenderDLT($user_login_id, $json);

        // assign my devices
        $imeiID = [];
        foreach ($devices as  $dev) {
            $imeiID = $dev;
            // $imeiID .= $dev;
        }
          $dataQuery = json_encode($imeiID);
          $dataQuery = str_replace('[','',$dataQuery);
          $dataQuery = str_replace(']','',$dataQuery);
          $dataQuery =  $dataQuery;

          $qeuryDB = DB::select("SELECT `id` FROM `device` WHERE `uniqueId` IN ($dataQuery)");

          $idx = [];
          foreach($qeuryDB as $ids){
            $idx[] = $ids->id;
          }

        // sync my device
         $user = User::find($user_login_id);
         $user->devices()->sync($idx);

        return redirect('/sale/show/' . $user_id);
    }

    public function curlSenderDLT($userID, $json)
    {

        $url = "http://api.wetrustgps.com:7899/api/assign-device-to-user/$userID";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type: application/json"]);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

        $json_response = curl_exec($curl);
        curl_close($curl);
        return $json_response;
    }

    public function createCarOnAPI(Request $request)
    {

        $deviceJSON = json_encode([
            'device_id' => $request->get('imei'),
            'device_name' => $request->get('name'),
            'device_tel_no' => $request->get('tel'),
            'is_deleted' => 0,
            'speed_limit' => 80,
            'allow_send_data_to_dlt' => 1,
        ]);

        $ch = curl_init('http://api.wetrustgps.com:7899/api/devices/create');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $deviceJSON);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($deviceJSON))
        );

        $result = curl_exec($ch);

        return redirect('/device-status?imei=' . $request->get('imei'));
    }


    public function findIMEIID($imei){
        $imeiData = DB::table('device')->where('uniqueId', $imei)->get();
        return $imeiData[0]->id;
    }

}
