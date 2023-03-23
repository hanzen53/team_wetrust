<?php

namespace App\Http\Controllers;

use App\User;
use App\DLTCar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LineAppController extends Controller
{

	public function checkLogin(Request $request){
		$data = $request->all();
		//Log::debug($data);
        $username = $data['username'];
		$password = $data['password'];
		$profile_img = $data['profile_img'];
		$display_name = $data['display_name'];
        $uuid = $data['uuid'];
        $user_login_id =  $data['user_login_id'];
		
		Log::debug($user_login_id);

        if (Auth::attempt(['username' => $username, 'password' => $password])) {

			$user = User::where('username',$username)->first();
			$user->line_uuid =  $uuid;
			$user->line_profile_img =  $profile_img;
			$user->line_display_name =  $display_name;
			$user->save();
			
            return response()->json([
                'status'=> true,
				'msg'=> 'Login success',
				'user_data' => Auth::user()
            ],200);
        }else{
            return response()->json([
                'status'=> false,
                'msg'=> 'username not found',
            ],401);
        }
    }

    public function liffApp(Request $request)
    {
        return view('liff-app');
    }

    public function realTimeTracking($imei){
        return view('realtime-tracking',compact('imei'));
    }

    public function scanme($id,Request $request){
        $dltCar = DLTCar::find($id);
		$pivot = $dltCar->gps_stock()->first();

		if($pivot){
			$pivot_install_date = Carbon::parse($dltCar->gps_stock()->withPivot('install_date')->first()->pivot->install_date)->format('d-m-Y');


			$provinceText = $this->provineMap($dltCar->register_province);
			$gpsModelNumber = $this->dltNumber($pivot->gps_model);

			$firstChar = mb_substr($dltCar->register_name,0,1);
			if($firstChar == 0){
				$char = mb_substr($dltCar->register_name,1,2);
				$number = mb_substr($dltCar->register_name,-4);
				$register_number = $char.'-'.$number;

			}else{
				$char = mb_substr($dltCar->register_name,0,2);
				$number = mb_substr($dltCar->register_name,-4);
				$register_number = $char.'-'.$number;
			}

			$unit_id = $this->dltCerUnitID($pivot->gps_model);

			$today = Carbon::now()->format('d-m-Y');

			$data = [
				'dltCar' => $dltCar,
				'dlt_bookStock' => $dltCar->gps_stock()->withPivot('gps_stock_id')->first()->pivot->gps_stock_id,
				'pivot_install_date' => $pivot_install_date,
				'pivot' => $pivot,
				'provinceText'=> $provinceText,
				'gpsModelNumber' => $gpsModelNumber,
				'register_number' => $register_number,
				'dlt_type' => $this->dltType($pivot->gps_model),
				'today' => $today,
				'sign' => 0,
				'unit_id' => $unit_id.''.$pivot->unit_id
			];
			$imei = substr($data['unit_id'],-15);

            return view('scan-me',compact('data','pivot','dltCar','imei'));

		}else{
			return redirect('/gps/assign/'.$id);
		}
    }


    /**
	 * @param $provineID
	 * @return string
	 */
	private function provineMap($provineID){

		switch ($provineID){
			case '001':
				return 'กรุงเทพมหานคร';
				break;
			case '100':
				return 'ชัยนาท';
				break;
			case '101':
				return 'สิงห์บุรี';
				break;
			case '102':
				return 'ลพบุรี';
				break;
			case '103':
				return 'อ่างทอง';
				break;
			case '104':
				return 'สระบุรี';
				break;
			case '105':
				return 'พระนครศรีอยุธยา';
				break;
			case '106':
				return 'ปทุมธานี';
				break;
			case '107':
				return 'นนทบุรี';
				break;
			case '108':
				return 'สมุทรปราการ';
				break;
			case '200':
				return 'นครนายก';
				break;
			case '201':
				return 'ปราจีนบุรี';
				break;
			case '202':
				return 'ฉะเชิงเทรา';
				break;
			case '203':
				return 'ชลบุรี';
				break;
			case '204':
				return 'ระยอง';
				break;
			case '205':
				return 'จันทบุรี';
				break;
			case '206':
				return 'ตราด';
				break;
			case '207':
				return 'สระแก้ว';
				break;
			case '300':
				return 'ชัยภูมิ';
				break;
			case '301':
				return 'ยโสธร';
				break;
			case '302':
				return 'อุบลราชธานี';
				break;
			case '303':
				return 'ศรีสะเกษ';
				break;
			case '304':
				return 'บุรีรัมย์';
				break;
			case '305':
				return 'นครราชสีมา';
				break;
			case '306':
				return 'สุรินทร์';
				break;
			case '307':
				return 'อำนาจเจริญ';
				break;
			case '308':
				return 'หนองบัวลำภู';
				break;
			case '309':
				return 'บึงกาฬ';
				break;
			case '400':
				return 'หนองคาย';
				break;
			case '401':
				return 'เลย';
				break;
			case '402':
				return 'อุดรธานี';
				break;
			case '403':
				return 'นครพนม';
				break;
			case '404':
				return 'สกลนคร';
				break;
			case '405':
				return 'ขอนแก่น';
				break;
			case '406':
				return 'กาฬสินธุ์';
				break;
			case '407':
				return 'มหาสารคาม';
				break;
			case '408':
				return 'ร้อยเอ็ด';
				break;
			case '409':
				return 'มุกดาหาร';
				break;
			case '500':
				return 'เชียงราย';
				break;
			case '501':
				return 'แม่ฮ่องสอน';
				break;
			case '502':
				return 'เชียงใหม่';
				break;
			case '503':
				return 'พะเยา';
				break;
			case '504':
				return 'น่าน';
				break;
			case '505':
				return 'ลำพูน';
				break;
			case '506':
				return 'ลำปาง';
				break;
			case '507':
				return 'แพร่';
				break;
			case '600':
				return 'อุตรดิตถ์';
				break;
			case '601':
				return 'สุโขทัย';
				break;
			case '602':
				return 'ตาก';
				break;
			case '603':
				return 'พิษณุโลก';
				break;
			case '604':
				return 'กำแพงเพชร';
				break;
			case '605':
				return 'พิจิตร';
				break;
			case '606':
				return 'เพชรบูรณ์';
				break;
			case '607':
				return 'นครสวรรค์';
				break;
			case '608':
				return 'อุทัยธานี';
				break;
			case '700':
				return 'สุพรรณบุรี';
				break;
			case '701':
				return 'กาญจนบุรี';
				break;
			case '702':
				return 'นครปฐม';
				break;
			case '703':
				return 'ราชบุรี';
				break;
			case '704':
				return 'สมุทรสาคร';
				break;
			case '705':
				return 'สมุทรสงคราม';
				break;
			case '706':
				return 'เพชรบุรี';
				break;
			case '707':
				return 'ประจวบคีรีขันธ์';
				break;
			case '707':
				return 'ประจวบคีรีขันธ์';
				break;
			case '800':
				return 'ชุมพร';
				break;
			case '801':
				return 'ระนอง';
				break;
			case '802':
				return 'สุราษฎร์ธานี';
				break;
			case '803':
				return 'พังงา';
				break;
			case '804':
				return 'นครศรีธรรมราช';
				break;
			case '805':
				return 'กระบี่';
				break;
			case '806':
				return 'ภูเก็ต';
				break;
			case '900':
				return 'พัทลุง';
				break;
			case '901':
				return 'ตรัง';
				break;
			case '902':
				return 'สงขลา';
				break;
			case '903':
				return 'สตูล';
				break;
			case '904':
				return 'ปัตตานี';
				break;
			case '905':
				return 'ยะลา';
				break;
			case '906':
				return 'นราธิวาส';
				break;
		}

	}


	public function dltType($gpsModel)
	{
		$gps_model = strtoupper($gpsModel);
		switch ($gps_model) {
			case 'AW-GPS-3G':
				return 'ANDAMAN';
				break;
			case 'TS107':
				return 'TS';
				break;
			case 'TS1073G':
				return 'TS';
				break;
			case 'T-333':
				return 'MEITRACK';
				break;
			case 'ET800D-3G':
				return 'YUWEI';
				break;
			case 'ET800M':
				return 'Onelink';
				break;
			case 'GT06E':
				return 'concox';
			case 'VT900':
				return 'iStartek';
				break;
		}
	}

	private function dltNumber($gps_model)
	{
		$gps_model = strtoupper($gps_model);
		switch ($gps_model) {
			case 'AW-GPS-3G':
				return '176/2560';
				break;
			case 'TS107':
				return '124/2559';
				break;
			case 'TS1073G':
				return '131/2559';
				break;
			case 'T-333':
				return '106/2559';
				break;
			case 'ET800D-3G':
				return '0418.3/6054';
				break;
			case 'ET800M':
				break;
			case 'GT06E':
				return '286/2561';
			case 'VT900':
				return '296/2561';
				break;
		}
    }
    
    public function dltCerUnitID($model)
	{


		if($model == 'AW-GPS-3G'){
			$unitIDPrefix = '0790006WET05';
		}elseif($model == 'TS107'){
			$unitIDPrefix = '0790002AT072';
		}elseif($model == 'TS1073G'){
			$unitIDPrefix = '0790003AT073';
		}elseif($model == 'T-333'){
			$unitIDPrefix = '079000100000';
		}elseif($model == 'ET800D-3G'){
			$unitIDPrefix = '';
		}elseif($model == 'ET800M'){
			$unitIDPrefix = '';
		}elseif($model == 'GT06E'){
			$unitIDPrefix = '0790009GT06E';
		}elseif($model == 'VT900'){
			$unitIDPrefix = '0790010VT900000';
		}else{
			$unitIDPrefix ='';
		}

		return $unitIDPrefix;
	}
}
