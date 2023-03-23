<?php

namespace App\Http\Controllers;

use App\Device;
use App\DLTCar;
use App\CarMaker;
use App\FileImage;
use Carbon\Carbon;
use App\DeviceStock;
use App\DLTCustomer;
use App\DLTMasterFile;
use App\MasterFileLog;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DLTCarController extends Controller
{
	public function __construct()
	{

	}


	public function assignGPS($id,Request $request){
		$dlt_car = DLTCar::find($id);
		$devices = DeviceStock::where('used','=',0)
            //->where('agent_use','=',1)
            ->whereNotNull('agent_use')
            ->get();
		$assigned = $dlt_car->gps_stock()->withPivot('install_date')->get();
		$userID =  $request->get('cid');

		return view('dlt-cars/assign-gps',compact('dlt_car','devices','assigned','userID'));
	}

	public function assignGPSPOST($id,Request $request){

		$installDate = Carbon::parse($request->get('install_date'))->format('Y-m-d');
		$nextBilling = Carbon::parse($installDate)->addYear()->format('Y-m-d');

		$stockID = $request->get('unit_id');
		$stock = DeviceStock::find($stockID);
		$stock->dlt_car()->attach([$id =>['install_date' => $installDate,'imei'=>$stock->unit_id]]);
		$stock->used = 1;
		$stock->assign_agent_date = Carbon::now()->format('Y-m-d');



		$dltCar = DLTCar::find($id);
		$deviceCheck = Device::where('uniqueId','=',$stock->unit_id)->first();

		if(!$deviceCheck) {

			$gps_model = '-';
			if ($stock->gps_model != '' || $stock->gps_model != NULL) {
				$gps_model = $stock->gps_model;
			}

			Device::create([
				'name' => $dltCar->register_name,
				'uniqueId' => $stock->unit_id,
				'gps_model' => $gps_model,
				'chassis_no' => $dltCar->register_chassi,
				'sim_carrie' => $stock->operator,
				'sim_phone_no' => $stock->phone_number,
				'make' => $dltCar->register_make,
				'model' => $dltCar->register_model,
				'company_id' => 0,
				'user_id' => 0,
				'server' => 'api.wetrustgps.com:7899',
				'install_date' => $installDate,
				'next_billing' => $nextBilling,
				'speed_limit' => 80,
				'is_dlt' => 1
			]);

		}else{
			$deviceCheck->name = $dltCar->register_name;
			$deviceCheck->uniqueId = $stock->unit_id;
			$deviceCheck->install_date = $installDate;
			$deviceCheck->next_billing = $nextBilling;

			$deviceCheck->save();

		}


		/**
		 * Update stock
		 */
		$dltCustomerID = $request->get('userID');

		$stock->install_date = $installDate;
		$stock->next_billing = $nextBilling;
		$stock->installed_on_car = $dltCar->register_name;
		$stock->customer_id = $dltCustomerID;
		$stock->customer_name = DLTCustomer::find($dltCustomerID)->name;
		$stock->save();




		return redirect('/sale/show/'.$request->get('userID'));
	}

	public function unAssignGPS(Request $request){

		$stock_id = $request->get('stock_id');
		$car_id = $request->get('car_id');
		$stock = DeviceStock::find($stock_id);
		$stock->dlt_car()->detach($car_id);
		$stock->used = 0;
		$stock->save();

		return redirect()->back();
	}


	/**
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
	 */
	public function dltCertificate($id,Request $request)
	{

		if($request->get('sign') == 0){
			$sign = 0;
		}else{
			$sign = 1;
		}

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
				'sign' => $sign,
				'unit_id' => $unit_id.''.$pivot->unit_id
			];



			$pdf = App::make('dompdf.wrapper');
			$pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('dlt-cars/certificate', $data)->setPaper('a4', 'portrait');;
			return $pdf->stream();
		}else{
			return redirect('/gps/assign/'.$id);
		}

	}




	public function addCarView($dlt_customer_id)
	{
		$car_maker = CarMaker::all();
		return view('dlt-cars/create',compact('dlt_customer_id','car_maker'));
	}

	/**
	 * Add car
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function addCar(Request $request)
	{

		$this->validate($request, [
			'register_name' => 'required',
			'register_type' => 'required',
			'register_chassi' => 'required',
			'register_province' => 'required',
			'register_make' => 'required',
			'owner_id' => 'required',
		]);
		$owner_id = $request->get('owner_id');

		$carName = $request->get('register_name');
		if($request->file('book_file_path')){
			$id_card           = $request->file('book_file_path');
			$filename          = $carName.'_'.$id_card->getClientOriginalName();
			$id_card_path      = $id_card->move('uploads/dlt-cars/', $filename);
		}else{
			$id_card_path = '';
		}



		$saleID = DLTCar::create([
			'owner_id' =>  $owner_id,
			'register_date' =>  Carbon::parse($request->get('register_date'))->format('Y-m-d'),
			'register_name' =>  $request->get('register_name'),
			'register_province' =>  $request->get('register_province'),
			'register_code_verify' =>  $request->get('register_code_verify'),
			'register_engine_type' => $request->get('register_engine_type'),
			'register_type' =>  $request->get('register_type'),
			'register_standard' =>  $request->get('register_standard'),
			'register_make' =>  $request->get('register_make'),
			'register_model' =>  $request->get('register_model'),
			'register_color' =>  $request->get('register_color'),
			'register_chassi' =>  $request->get('register_chassi'),
			'register_chassi_position' =>  $request->get('register_chassi_position'),
			'register_engine_make' =>  $request->get('register_engine_make'),
			'register_engine_number' =>  $request->get('register_engine_number'),
			'register_engine_number_position' =>  $request->get('register_engine_number_position'),
			'register_engine_total_piston' =>  $request->get('register_engine_total_piston'),
			'register_engine_total_horse_power' =>  $request->get('register_engine_total_horse_power'),
			'register_shaft' =>  $request->get('register_shaft'),
			'register_wheels' =>  $request->get('register_wheels'),
			'register_rubbers' =>  $request->get('register_rubbers'),
			'register_car_weight' =>  $request->get('register_car_weight'),
			'register_sit_passenger' =>  $request->get('register_sit_passenger'),
			'register_standup_passenger' =>  $request->get('register_standup_passenger'),
			'register_total_load_weight' =>  $request->get('register_total_load_weight'),
			'register_total_weight' =>  $request->get('register_total_weight'),
			'owner_name' =>  $request->get('owner_name'),
			'owner_start_date' =>   Carbon::parse($request->get('owner_start_date'))->format('Y-m-d'),
			'owner_card_id' =>  $request->get('owner_card_id'),
			'owner_nationality' =>  $request->get('owner_nationality'),
			'owner_address_one' =>  $request->get('owner_address_one'),
			'owner_address_auto' =>  $request->get('owner_address_auto'),
			'owner_transport_type' =>  $request->get('owner_transport_type'),
			'owner_authorized_code' =>  $request->get('owner_authorized_code'),
			'owner_authorized_expire_date' =>   Carbon::parse($request->get('owner_authorized_expire_date'))->format('Y-m-d'),
			'owner_has_ownership' =>  $request->get('owner_has_ownership'),
			'ownership_name' =>  $request->get('ownership_name'),
			'ownership_address_one' =>  $request->get('ownership_address_one'),
			'ownership_address_auto' =>  $request->get('ownership_address_auto'),
			'book_file_path' =>  $id_card_path,
			'who_add' =>  Auth::user()->id,
		]);



		Session::flash('success', 'Data added');
		return redirect('/sale/show/'.$owner_id);
	}

	/**
	 * @param $car_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function carShow($car_id)
	{
		$dltCar = DLTCar::find($car_id);
		$images = FileImage::where('car_id','=',$car_id)->get();
		return view('dlt-cars/edit',compact('dltCar','images'));
	}

	public function carUpdate($car_id,Request $request)
	{
		//return $request->all();

		$dltCar = DLTCar::find($car_id);

		$carName = $request->get('register_name');
		if($request->file('book_file_path')){
			$id_card           = $request->file('book_file_path');
			$filename          = $carName.'_'.$id_card->getClientOriginalName();
			$id_card_path      = $id_card->move('uploads/dlt-cars/', $filename);
		}else{
			$id_card_path = $dltCar->book_file_path;
		}


		$dltCar->owner_id =  $request->get('owner_id');
		$dltCar->register_date =  Carbon::parse($request->get('register_date'))->format('Y-m-d');
		$dltCar->register_name =  $request->get('register_name');
		$dltCar->register_province =  $request->get('register_province');
		$dltCar->register_code_verify =  $request->get('register_code_verify');
		$dltCar->register_engine_type =  $request->get('register_engine_type');
		$dltCar->register_type =  $request->get('register_type');
		$dltCar->register_standard =  $request->get('register_standard');
		$dltCar->register_make =  $request->get('register_make');
		$dltCar->register_model =  $request->get('register_model');
		$dltCar->register_color =  $request->get('register_color');
		$dltCar->register_chassi =  $request->get('register_chassi');
		$dltCar->register_chassi_position =  $request->get('register_chassi_position');
		$dltCar->register_engine_make =  $request->get('register_engine_make');
		$dltCar->register_engine_number =  $request->get('register_engine_number');
		$dltCar->register_engine_number_position =  $request->get('register_engine_number_position');
		$dltCar->register_engine_total_piston =  $request->get('register_engine_total_piston');
		$dltCar->register_engine_total_horse_power =  $request->get('register_engine_total_horse_power');
		$dltCar->register_shaft =  $request->get('register_shaft');
		$dltCar->register_wheels =  $request->get('register_wheels');
		$dltCar->register_rubbers =  $request->get('register_rubbers');
		$dltCar->register_car_weight =  $request->get('register_car_weight');
		$dltCar->register_sit_passenger =  $request->get('register_sit_passenger');
		$dltCar->register_standup_passenger =  $request->get('register_standup_passenger');
		$dltCar->register_total_load_weight =  $request->get('register_total_load_weight');
		$dltCar->register_total_weight =  $request->get('register_total_weight');
		$dltCar->owner_name =  $request->get('owner_name');
		$dltCar->owner_start_date =  Carbon::parse($request->get('owner_start_date'))->format('Y-m-d');
		$dltCar->owner_card_id =  $request->get('owner_card_id');
		$dltCar->owner_nationality =  $request->get('owner_nationality');
		$dltCar->owner_address_one =  $request->get('owner_address_one');
		$dltCar->owner_address_auto =  $request->get('owner_address_auto');
		$dltCar->owner_transport_type =  $request->get('owner_transport_type');
		$dltCar->owner_authorized_code =  $request->get('owner_authorized_code');
		$dltCar->owner_authorized_expire_date =  Carbon::parse($request->get('owner_authorized_expire_date'))->format('Y-m-d');
		$dltCar->owner_has_ownership =  $request->get('owner_has_ownership');
		$dltCar->ownership_name =  $request->get('ownership_name');
		$dltCar->ownership_address_one =  $request->get('ownership_address_one');
		$dltCar->ownership_address_auto =  $request->get('ownership_address_auto');
		$dltCar->book_file_path =  $id_card_path;
		$dltCar->who_add =  Auth::user()->id;

		$dltCar->save();


		Session::flash('success', 'Data added');
		return redirect('/sale/show/'.$request->get('owner_id'));

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


	public function postMasterFile(Request $request)
	{
		$dltCar = DLTCar::find($request->get('unit_id'));
		$pivot = $dltCar->gps_stock()->first();

		//return $pivot->gps_model;

		if($pivot->gps_model == 'AW-GPS-3G'){
			$unitIDPrefix = '0790006WET05';
		}elseif($pivot->gps_model == 'TS107'){
			$unitIDPrefix = '0790002AT072';
		}elseif($pivot->gps_model == 'TS1073G'){
			$unitIDPrefix = '0790003AT073';
		}elseif($pivot->gps_model == 'T-333'){
			$unitIDPrefix = '079000100000';
		}elseif($pivot->gps_model == 'ET800D-3G'){
			$unitIDPrefix = '';
		}elseif($pivot->gps_model == 'ET800M'){
			$unitIDPrefix = '';
		}elseif($pivot->gps_model == 'GT06E'){
			$unitIDPrefix = '0790009GT06E';
		}elseif($pivot->gps_model == 'VT900'){
			$unitIDPrefix = '0790010VT900000';
		}else{
			$unitIDPrefix ='';
		}

		if($pivot){

			$provinceText = $dltCar->register_province;

			$deviceJSON = json_encode([
				"vender_id" => 79,
				"unit_id"=> $unitIDPrefix.$pivot->unit_id,
				"vehicle_id" => $dltCar->register_name,
				"vehicle_type" => $dltCar->register_make,
				"vehicle_chassis_no" =>$dltCar->register_chassi,
				"vehicle_register_type" => $dltCar->register_type,
				"province_code" => $provinceText,
				"card_reader" => 1
			]);

			//return $deviceJSON;

			$ch = curl_init('http://api.wetrustgps.com:8999/api/add-master-file');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $deviceJSON);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($deviceJSON))
			);

			$result = curl_exec($ch);

			$created_mf_date = Carbon::now();

			MasterFileLog::create([
				'unit_id' => $unitIDPrefix.$pivot->unit_id,
				'chassis_no' => $dltCar->register_chassi,
				'name' => $dltCar->register_name,
				'car_make' => $dltCar->register_make,
				'vehicle_type' => $dltCar->register_type,
				'created_by' => Auth::user()->name,
				'created_mf_date' => $created_mf_date,
				'to_dlt_next_round' => Carbon::parse($created_mf_date)->addDays(365),
			]);

		}else{
			return redirect()->back();
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


	public function editPlate()
	{
		return view('dlt-cars/update-car-plate');
	}

	public function updatePlate(Request $request)
	{
		$unit_id = trim($request->get('unit_id'));
		$name = trim($request->get('car_name'));

		$data = json_encode(['device_name' => $name]);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "7899",
			CURLOPT_URL => "http://api.wetrustgps.com:7899/api/devices/update/".$unit_id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"postman-token: 79f4fd4d-da1f-1b43-e859-b0e92eb844fb"
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


	public function updateSpeed()
	{
		return view('dlt-cars/update-car-speed');
	}
	public function postUpdateSpeed(Request $request)
	{
		$unit_id = trim($request->get('device_id'));
		$speedLimit = trim($request->get('speed_limit'));

		$data = json_encode(['device_id'=> $unit_id ,'speed_limit' => $speedLimit]);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "7899",
			CURLOPT_URL => "http://api.wetrustgps.com:7899/api/device-update-speed-limit",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"postman-token: 79f4fd4d-da1f-1b43-e859-b0e92eb844fb"
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

	public function manualSentDLT()
	{
		return view('dlt-cars/manual-sent-dlt');
	}
	public function manualSentDLTPOST(Request $request)
	{
		$unit_id = trim($request->get('unit_id'));
		$driver_id = trim($request->get('driver_id'));
		$lat = trim($request->get('lat'));
		$lon = trim($request->get('lon'));

		$data = json_encode(['unit_id'=> $unit_id ,'driver_id' => $driver_id,'lat'=> $lat,'lon'=> $lon]);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "7899",
			CURLOPT_URL => "http://api.wetrustgps.com:7899/api/manual-sent-data-to-dlt",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"postman-token: 79f4fd4d-da1f-1b43-e859-b0e92eb844fb"
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

		Session::flash('success',"ส่งข้อมูลแล้ว");

		return redirect()->back();

	}

	public function listAllCars()
	{
		return view('dlt-cars/list-all-cars');
	}

	public function allowDLT($dlt_unit_id)
	{

		//$device = substr($dlt_unit_id,12);
		$device = $dlt_unit_id;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "7899",
			CURLOPT_URL => "http://api.wetrustgps.com:7899/api/devices/update/$device",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"allow_send_data_to_dlt\": 1\n}",
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Content-Type: application/json",
				"Postman-Token: 44d5ac5a-8c10-49ba-9a9b-dbe3c9f72f0c"
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

	public function blockDLT($dlt_unit_id)
	{
		//$device = substr($dlt_unit_id,12);
		$device = $dlt_unit_id;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "7899",
			CURLOPT_URL => "http://api.wetrustgps.com:7899/api/devices/update/$device",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"allow_send_data_to_dlt\": 0\n}",
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Content-Type: application/json",
				"Postman-Token: 44d5ac5a-8c10-49ba-9a9b-dbe3c9f72f0c"
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

	/**
	 * Send master file to DLT server
	 * @param $dlt_unit_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @internal param Request $request
	 */
	public function deleteMasterFileToDLTServer($dlt_unit_id)
	{

		$device = $dlt_unit_id;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://gpsservice.dlt.go.th/masterfile/rmvByUnit/$device",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "DELETE",
			CURLOPT_HTTPHEADER => array(
				"authorization: Basic d2VnbG9iYWw6NzRyakg0aFJaU3JI",
				"cache-control: no-cache",
				"content-type: application/json",
				"postman-token: 86b422dd-7bf5-61a2-2513-57d49bf322a1"
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

		return redirect()->back();
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


	public function listAllMF(Request $request){
		$update = $request->get('update');
		if($update == 1){
			$this->pullMasterFileDLT();
		}
		$cars = DLTMasterFile::all();
		//$cars = DLTMasterFile::paginate(20);
		return view('dlt-cars/list-all-mf',compact('cars'));
	}

	public function listAllMFOffline(Request $request){

		if($request->get('interval')){
			$daySelect = $request->get('interval');
		}else{
			$daySelect = 1;
		}

		$cars = DB::select("SELECT * FROM `dlt_master_file`
		WHERE `update_time`  <   DATE(NOW() - INTERVAL $daySelect DAY)");
		return view('dlt-cars/list-all-mf',compact('cars'));
	}


	public function mfNote(Request $request){

	}

	public function pullMasterFileDLT(){
		
		$curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://gpsservice.dlt.go.th/masterfile/getList/0/15000",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
           // "Authorization: Basic d2VnbG9iYWw6NzRyakg0aFJaU3JI",
            "Authorization: Basic d2VnbG9iYWw6NzRyakg0aFJaU3JI",
            "Postman-Token: bf16409c-89c3-4678-97f0-885803ae214a",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            //echo $response;

			$data = json_decode($response,true);
			
			DLTMasterFile::truncate();

            foreach ($data['results'] as $key => $value) {
                //echo $value['unit_id'] .'<br/>';
                DLTMasterFile::updateOrCreate([
                'unit_id' => $value['unit_id'],
                'imei' => substr($value['unit_id'],-15),
                'vehicle_id' => $value['vehicle_id'],
                'vehicle_type' => $value['vehicle_type'],
                'vehicle_chassis_no' => $value['vehicle_chassis_no'],
                'vehicle_register_type' => $value['vehicle_register_type'],
                'card_reader' => $value['card_reader'],
                'province_code' => $value['province_code'],
                'province_name' => $this->provineMap($value['province_code']),
                'data_status' => $value['data_status'],
                'log_time' => Carbon::parse($value['log_time'])->format('Y-m-d H:i'),
                // 'update_time' => Carbon::parse($value['update_time'])->format('Y-m-d H:i'),
            ]);
            } 

            return 'Done';
        }
	}
	
	/**
	 * Receive last know update devices
	 * @param Request $request
	 * @return array
	 */
	public function deviceLastUpdate(Request $request){

		$data = $request->all();

		//Log::info($data);
		foreach ($data as $value){

			if(isset($value['imei'])){
				$device = DLTMasterFile::where('imei', '=', $value['imei'])->first();
				if($device){
					$device->update_time = $value['last_update'];
					$device->save();
				}
			}
		}
		return "Saved";
	}


	public function updateMasterFileOwner(){

		 $dlt_master_file = DB::select("SELECT `imei` FROM `dlt_master_file` WHERE `customer_id` IS NULL LIMIT 1000");
	
		foreach ($dlt_master_file as $value) {
			
		$data = $this->getOwnerIMEI($value->imei);
		
			if($data != 'no-data'){

				$customerID =  $data->customer_id;
				$customerName =  $data->customer_name;

					DB::table('dlt_master_file')
					->where('imei', $value->imei)
					->update(['customer_id' => $customerID,'customer_name' => $customerName]);
			}
		}

		return 'Done';
	}


	public function getOwnerIMEI($imei){
		$data = DB::table('device_stock')
		->where('unit_id',$imei)
		->first();

		if($data){
			return $data;
		}else{
			return 'no-data';
		}
	}


}


