<?php

namespace App\Http\Controllers;

use App\Server;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServerController extends Controller
{
    public function index(Request $request)
    {
        $servers = Server::all();
        $url = '';
        if ($request->get('server')) {
            $server = Server::find($request->get('server'));
            if ($server->version == 'V3') {
                $url = 'https://' . $server->ip . ':3000/devices';
            } else {
                $url = 'https://api01.wetrustgps.com:7899/api/device-on-server/' . $server->hostname;
            }
        }

        return view('server', compact('servers', 'url'));
    }

    public function updateStockID()
    {

        $device_stock = DB::table('device_stock')
            ->where('add_to_mongo_stock_id', 0)
            ->paginate(100);

        foreach ($device_stock as $key => $value) {

            $status = $this->sendTOAPIserver($value->unit_id, $value->id);
            if ($status) {
                DB::table('device_stock')
                    ->where('id', $value->id)
                    ->update([
                        'add_to_mongo_stock_id' => 1,
                    ]);
            }
        }

        return $device_stock->links();

    }

    public function sendTOAPIserver($imei, $stockID)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "7899",
            CURLOPT_URL => "http://api.wetrustgps.com:7899/api/device-update-stock-id/" . $imei,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"stock_id\" : $stockID\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: b8ae9783-a195-40ad-9efc-1d3b24c9e50f",
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return true;
        }
    }

    public function rebootServer(Request $request)
    {

        $servers = Server::all();

        return view('server-reboot', compact('servers'));
    }

    public function rebootServerAction(Request $request)
    {
        //return $request->all();
        if ($request->get('tag') == 'Lite') {
            $this->curlAction(66816732);
            return redirect()->back();
        }
        if ($request->get('tag') == 'Gateway') {

            $servers = [];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.digitalocean.com/v2/droplets?tag_name=Gateway",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer 205ed27f20c228c6abe6cb5411670c3dbcc14e1776fd8c26519f6b593fb0e4f4",
                    "Postman-Token: fbea693a-b3fe-4f31-8733-60484de3650e",
                    "cache-control: no-cache",
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                //   return   $responseJson = file_get_contents($response);
                $response = json_decode($response, true);
                //return $response['droplets'][0]['id'];

                foreach ($response['droplets'] as $server) {

                    //echo 'ID ' . $server['id'].' '. 'Name '. $server['name'].'<br/>';
                    echo $this->curlAction($server['id']) . '<br/>';
                }

            }
            return redirect()->back();
        }

    }

    public function curlAction($droplet_ID)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.digitalocean.com/v2/droplets/$droplet_ID/actions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"type\": \"reboot\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer 205ed27f20c228c6abe6cb5411670c3dbcc14e1776fd8c26519f6b593fb0e4f4",
                "Content-Type: application/json",
                "Postman-Token: 4b5b6528-caff-4cb9-867a-585e169ad3d1",
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

}
