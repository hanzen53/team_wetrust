<?php

namespace App\Http\Controllers;

use App\User;
use App\Agent;
use App\Unkey;
use App\DLTCar;
use App\FileImage;
use Carbon\Carbon;
use App\DLTCustomer;
use App\DLTCustomerNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
	public function __construct()
	{
	}
	
	private $userID;
	
	public function getUserID()
	{
		return $this->firstField;
	}
	
	public function setUserID($x)
	{
		$this->firstField = $x;
	}
	
	/**
	* Dashboard.
	*
	* @param Request $request
	*
	* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	*/
	public function dashboard(Request $request)
	{
		$query = urldecode($request->get('q'));
		
		if ($query) {
			$mySold = DLTCustomer::where('citizen_id', 'LIKE', '%'.$query.'%')
			->orWhere('name', 'LIKE', '%'.$query.'%')
			->orWhere('business_name', 'LIKE', '%'.$query.'%')
			->orWhere('tel', 'LIKE', '%'.$query.'%')
			->where('status', 1)
			->paginate(25);
			
			$customerV3 = User::where('name', 'LIKE', '%'.$query.'%')
			->orWhere('username', 'LIKE', '%'.$query.'%')
			->orWhere('email', 'LIKE', '%'.$query.'%')
			->orWhere('tel', 'LIKE', '%'.$query.'%')
			->orWhere('line', 'LIKE', '%'.$query.'%')
			->paginate(25);
		} else {
			$mySold = DLTCustomer::orderBy('id', 'desc')->paginate(25);
			$customerV3 = [];
		}
		
		return view('sale/dashboard', compact('mySold', 'customerV3'));
	}
	
	/**
	* Create.
	*
	* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	*/
	public function create()
	{
		return view('sale/create');
	}
	
	
	public function dltCustomerNote(Request $request)
	{
		$note = DLTCustomerNote::create([
			'type' => $request->get('type'),
			'content' => $request->get('content'),
			'user_id' => $request->user()->id,
			'customer_id' => $request->get('customer_id'),
			]);
			
			return redirect()->back();
		}
		
		/**
		* Save data.
		*
		* @param Request $request
		*
		* @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
		*/
		public function store(Request $request){
			$request->validate([
				'tel' => 'required',
				'email' => 'required',
				'username' => 'required',
				]);
				$tel = $request->get('tel');
				
				if ($request->file('id_card')) {
					$id_card = $request->file('id_card');
					$filename = $tel.'_'.$id_card->getClientOriginalName();
					$id_card_path = $id_card->move('uploads/dlt-customer/', $filename);
				} else {
					$id_card_path = '';
				}
				
				if ($request->get('confirm_order_status') == 'on') {
					$cf = 1;
				} else {
					$cf = 0;
				}
				
				if ($request->get('user_type') == 'new') {
					$userCreated = User::create([
						'user_type' => 'dlt',
						'username' => trim($request->get('username')),
						'password' => bcrypt(trim($request->get('password'))),
						'email' => $request->get('email'),
						'name' => $request->get('name'),
						'company_id' => 0,
						'server' => 'api.wetrustgps.com:7899',
						'role' => 'user',
						'status' => 1,
						'user_update_profile' => 0,
						]);
						
						DLTCustomer::create([
							'citizen_id' => trim($request->get('citizen_id')),
							'name' => $request->get('name'),
							'business_name' => $request->get('business_name'),
							'tel' => $request->get('tel'),
							'car_type' => $request->get('car_type'),
							'quantity' => $request->get('quantity'),
							'note' => $request->get('note'),
							'booking_install_date' => Carbon::parse($request->get('booking_install_date'))->format('Y-m-d'),
							'confirm_order_status' => $cf,
							'sold_by_sale_id' => $request->user()->id,
							'followup_by_afer_sale_service_id' => 0,
							'need_quotation' => $request->get('need_quotation'),
							'id_card' => $id_card_path,
							'name_1' => $request->get('name_1'),
							'tel_1' => $request->get('tel_1'),
							'name_2' => $request->get('name_2'),
							'tel_2' => $request->get('tel_2'),
							'name_3' => $request->get('name_3'),
							'tel_3' => $request->get('tel_3'),
							'line_id' => $request->get('line_id'),
							'address_one' => $request->get('address_one'),
							'address_auto' => $request->get('address_auto'),
							'username' => trim($request->get('username')),
							'password' => trim($request->get('password')),
							'email' => trim($request->get('email')),
							'user_login_id' => $userCreated->id,
							]);
							
							$userJSON = json_encode([
								'email' => $request->get('email'),
								'user_id' => $userCreated->id,
								'username' => trim($request->get('username')),
								'name' => trim($request->get('name')),
								'company_id' => 0,
								]);
								
								$ch = curl_init('http://api.wetrustgps.com:7899/api/users/create');
								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
								curl_setopt($ch, CURLOPT_POSTFIELDS, $userJSON);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
								curl_setopt($ch, CURLOPT_HTTPHEADER, array(
									'Content-Type: application/json',
									'Content-Length: '.strlen($userJSON), )
								);
								
								$result = curl_exec($ch);
							} else {
								$userCreated = User::where('email', '=', $request->get('email'))->first();
								DLTCustomer::create([
									'citizen_id' => trim($request->get('citizen_id')),
									'name' => $request->get('name'),
									'business_name' => $request->get('business_name'),
									'tel' => $request->get('tel'),
									'car_type' => $request->get('car_type'),
									'quantity' => $request->get('quantity'),
									'note' => $request->get('note'),
									'booking_install_date' => Carbon::parse($request->get('booking_install_date'))->format('Y-m-d'),
									'confirm_order_status' => $cf,
									'sold_by_sale_id' => $request->user()->id,
									'followup_by_afer_sale_service_id' => 0,
									'need_quotation' => $request->get('need_quotation'),
									'id_card' => $id_card_path,
									'name_1' => $request->get('name_1'),
									'tel_1' => $request->get('tel_1'),
									'name_2' => $request->get('name_2'),
									'tel_2' => $request->get('tel_2'),
									'name_3' => $request->get('name_3'),
									'tel_3' => $request->get('tel_3'),
									'line_id' => $request->get('line_id'),
									'address_one' => $request->get('address_one'),
									'address_auto' => $request->get('address_auto'),
									'username' => trim($request->get('username')),
									'password' => trim($request->get('password')),
									'email' => trim($request->get('email')),
									'user_login_id' => $userCreated->id,
									]);
								}
								
								return redirect('/sale/dashboard');
							}
							
							/**
							* Edit form.
							*
							* @param $id
							*
							* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
							*/
							public function edit($id)
							{
								$customer = DLTCustomer::find($id);
								$user_login = User::all();
								$agents = Agent::all();
								
								return view('sale/edit', compact('customer', 'user_login', 'agents'));
							}
							
							public function update($id, Request $request)
							{
								$customer = DLTCustomer::find($id);
								
								$tel = $request->get('tel');
								
								if ($request->file('id_card')) {
									$id_card = $request->file('id_card');
									$filename = $tel.'_'.$id_card->getClientOriginalName();
									$id_card_path = $id_card->move('uploads/dlt-customer/', $filename);
								} else {
									$id_card_path = $customer->id_card;
								}
								
								if ($request->get('confirm_order_status') == 'on') {
									$cf = 1;
								} else {
									$cf = 0;
								}
								
								$customer->citizen_id = trim($request->get('citizen_id'));
								$customer->name = $request->get('name');
								$customer->tel = $tel;
								$customer->business_name = $request->get('business_name');
								$customer->line_id = $request->get('line_id');
								$customer->car_type = $request->get('car_type');
								$customer->quantity = $request->get('quantity');
								
								$customer->name_1 = $request->get('name_1');
								$customer->tel_1 = $request->get('tel_1');
								$customer->name_2 = $request->get('name_2');
								$customer->tel_2 = $request->get('tel_2');
								$customer->name_3 = $request->get('name_3');
								$customer->tel_3 = $request->get('tel_3');
								
								$customer->id_card = $id_card_path;
								
								$customer->address_one = $request->get('address_one');
								$customer->address_auto = $request->get('address_auto');
								
								$customer->note = $request->get('note');
								$customer->booking_install_date = Carbon::parse($request->get('booking_install_date'))->format('Y-m-d');
								$customer->confirm_order_status = $cf;
								$customer->sold_by_sale_id = $request->user()->id;
								$customer->need_quotation = $request->get('need_quotation');
								
								$agent = Agent::find($request->get('agent_id'));
								$customer->agent_id = $request->get('agent_id');
								$customer->agent_name = $agent->agent_name;
								$customer->billing_channel = $request->get('billing_channel');
								
								if ($request->get('user_login_id') != 0) {
									$customer->user_login_id = $request->get('user_login_id');
									
									$user = User::find($request->get('user_login_id'));
									$customer->username = $user->username;
									$customer->email = $user->email;
								}
								
								if ($request->get('user_login_id')) {
									$customer->password = $request->get('password');
								}
								
								$customer->save();
								
								return redirect('/sale/dashboard');
							}
							
							public function show($id, Request $request)
							{
								$customer = DLTCustomer::find($id);
								$carsFind = DLTCar::where('owner_id', '=', $id)->get();
								$images = FileImage::where('imei', '=', $id)->where('car_id', '=', 0)->get();
								$loginUsers = User::where('parent_user', $id)->get();
								
								$cars = [];
								
								foreach ($carsFind as $car) {
									if ($car->gps_stock()->exists()) {
										$firstChar = mb_substr($car->register_name, 0, 1);
										if ($firstChar == 0) {
											$char = mb_substr($car->register_name, 1, 2);
											$number = mb_substr($car->register_name, -4);
											$register_number = $char.'-'.$number;
										} else {
											$char = mb_substr($car->register_name, 0, 2);
											$number = mb_substr($car->register_name, -4);
											$register_number = $char.'-'.$number;
										}
										
										$cars[] = [
											'id' => $car->id,
											'unit_id' => $car->gps_stock[0]->unit_id,
											'tel' => $car->gps_stock[0]->phone_number,
											'install_date' => Carbon::parse($car->gps_stock()->withPivot('install_date')->first()->pivot->install_date)->format('d-m-Y'),
											'register_name' => $register_number,
											'register_chassi' => $car->register_chassi,
											'register_province' => $this->province_name($car->register_province),
											'register_make' => $car->register_make,
										];
									} else {
										$firstChar = mb_substr($car->register_name, 0, 1);
										if ($firstChar == 0) {
											$char = mb_substr($car->register_name, 1, 2);
											$number = mb_substr($car->register_name, -4);
											$register_number = $char.'-'.$number;
										} else {
											$char = mb_substr($car->register_name, 0, 2);
											$number = mb_substr($car->register_name, -4);
											$register_number = $char.'-'.$number;
										}
										
										$cars[] = [
											'id' => $car->id,
											'unit_id' => '',
											'tel' => '',
											'install_date' => '-',
											'register_name' => $register_number,
											'register_chassi' => $car->register_chassi,
											'register_province' => $this->province_name($car->register_province),
											'register_make' => $car->register_make,
										];
									}
								}
								
								$notesQuery = DLTCustomerNote::where('customer_id', '=', $id)->get();
								
								$notes = [];
								foreach ($notesQuery as $value) {
									$notes[] = [
										'note_type' => $value->type,
										'note_content' => $value->content,
										'note_created_at' => $value->created_at.'',
										'who_note' => User::find($value->user_id),
									];
								}
								
								
								return view('sale/show', compact('customer', 'cars', 'images', 'notes', 'loginUsers'));
							}
							
							/**
							* @param Request $request
							*
							* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
							*/
							public function quick(Request $request)
							{
								
								return view('theme-v2/sale/step-one');
							}
							
							/**
							* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
							*/
							public function unKey()
							{
								$unKey = Unkey::where('entry', '=', 0)->get();
								
								return view('/sale/un-key', compact('unKey'));
							}
							
							/**
							* Store a newly created resource in storage.
							*
							* @param \Illuminate\Http\Request $request
							*
							* @return \Illuminate\Http\Response
							*/
							public function storeFilesOrImagesUnkey(Request $request)
							{
								$path = $request->get('save_to_path');
								$prefix = $request->get('prefix');
								$file = $request->file('file');
								$file_name = $file->getClientOriginalName();
								$filePath = $file->move('uploads/'.$path.'/', $prefix.'_'.$file_name);
								
								if ($request->get('car_id')) {
									$car_id = $request->get('car_id');
								} else {
									$car_id = 0;
								}
								
								FileImage::create([
									'file_name' => $file_name,
									'path' => $filePath,
									'imei' => $prefix,
									'car_id' => $car_id,
									'who_upload' => $request->get('who_upload'),
									]);
									
									return 'Done';
								}
								
								public function unKeyShow($citizen_id)
								{
									$unKey = Unkey::where('id_card_or_tax_id', '=', $citizen_id)->get();
									
									return view('/sale/un-key-show', compact('unKey', 'citizen_id'));
								}
								
								public function markTodone($id)
								{
									$unKey = Unkey::find($id);
									$unKey->status = 1;
									$unKey->save();
									
									return redirect('/sale/un-key');
								}
								
								public function destroy($id)
								{
									$car = DLTCar::find($id);
									$car->delete();
									
									return redirect()->back();
								}
								
								public function province_name($provineID)
								{
									switch ($provineID) {
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
								
								public function userInvoice($id, Request $request)
								{
									$year = $request->get('year');
									$month = $request->get('month');
									$from_field = $request->get('from_field'); // 0 is install date | 1 is due date
									
									if ($from_field == 1) {
										$year = $year - 1;
										$conCat = $year.'-'.$month;
									}
									$conCat = $month;
									
									$customer = DLTCustomer::find($id);
									$carsFind = DLTCar::where('owner_id', '=', $id)->get();
									
									foreach ($carsFind as $car) {
										if ($car->gps_stock()->exists()) {
											
											$firstChar = mb_substr($car->register_name, 0, 1);
											if ($firstChar == 0) {
												$char = mb_substr($car->register_name, 1, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											} else {
												$char = mb_substr($car->register_name, 0, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											}
											
											$fillterMonthYear = Carbon::parse($car->gps_stock()->withPivot('install_date')->first()->pivot->install_date)->format('m');
											
											if ($conCat == $fillterMonthYear) {
												$cars[] = [
													'id' => $car->id,
													'unit_id' => $car->gps_stock[0]->unit_id,
													'install_date' => Carbon::parse($car->gps_stock()->withPivot('install_date')->first()->pivot->install_date)->format('d-m-Y'),
													'register_name' => $register_number,
													'register_chassi' => $car->register_chassi,
													'register_province' => $this->province_name($car->register_province),
													'register_make' => $car->register_make,
												];
											}
										} else {
											$firstChar = mb_substr($car->register_name, 0, 1);
											if ($firstChar == 0) {
												$char = mb_substr($car->register_name, 1, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											} else {
												$char = mb_substr($car->register_name, 0, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											}
											
											$cars[] = [
												'id' => $car->id,
												'unit_id' => '',
												'install_date' => '-',
												'register_name' => $register_number,
												'register_chassi' => $car->register_chassi,
												'register_province' => $this->province_name($car->register_province),
												'register_make' => $car->register_make,
											];
										}
									}
									
									return view('documents/user-invoice-index', compact('customer', 'cars','year'));
								}
								
								public function userInvoicePost($id, Request $request)
								{
									$customer = DLTCustomer::find($id);
									$carSelected = $request->get('selected');
									$carprice = $request->get('price');
									$document = $request->get('document-type');
									$for_year = $request->get('for_year');
									$invTemp = $request->get('inv-temp');
									
									foreach ($carSelected as $index => $carID) {
										$car = DLTCar::find($carID);
										
										if ($car->gps_stock()->exists()) {
											$firstChar = mb_substr($car->register_name, 0, 1);
											if ($firstChar == 0) {
												$char = mb_substr($car->register_name, 1, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											} else {
												$char = mb_substr($car->register_name, 0, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											}
											
											$cars[] = [
												'id' => $car->id,
												'unit_id' => $car->gps_stock[0]->unit_id,
												'install_date' => Carbon::parse($car->gps_stock()->withPivot('install_date')->first()->pivot->install_date)->format('d-m-Y'),
												'register_name' => $register_number,
												'register_chassi' => $car->register_chassi,
												'register_province' => $this->province_name($car->register_province),
												'register_make' => $car->register_make,
												'price' => $carprice[$index],
												'for_year' => $for_year[$index],
											];
										} else {
											$firstChar = mb_substr($car->register_name, 0, 1);
											if ($firstChar == 0) {
												$char = mb_substr($car->register_name, 1, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											} else {
												$char = mb_substr($car->register_name, 0, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											}
											
											$cars[] = [
												'id' => $car->id,
												'unit_id' => '',
												'install_date' => '-',
												'register_name' => $register_number,
												'register_chassi' => $car->register_chassi,
												'register_province' => $this->province_name($car->register_province),
												'register_make' => $car->register_make,
												'price' => 0,
												'for_year' => $car->for_year,
											];
										}
									}
									
									if ($document == 'invoice') {
										
										$thisMonth = Carbon::now()->format('m');
										$thisYear = Carbon::now()->format('y');
										
										$lastINV = DB::table('invoices')
										->whereMonth('created_at', $thisMonth)
										// ->groupBy('invoice_id')
										->get();
										//->count();
										
										$lastINV = count($lastINV) + 1;
										
										if($invTemp != ''){
											$invoiceID = $invTemp;
										}else{
											$invoiceID = 'INV'.$thisYear.$thisMonth.str_pad($lastINV, 4, '0', STR_PAD_LEFT);
										}

										
										
										$key = 'price';
										$amount = array_sum(array_column($cars, $key));
										
										$this->curlCreateQRCode($invoiceID, $amount);
										
										$this->insertINV($invoiceID, $id, $cars, $amount);
										
										return view('documents/invoice-post', compact('customer', 'cars', 'invoiceID','thisYear','invoiceID'));
									}
									
									if ($document == 'warning') {
										$data = [
											'cars' => $cars,
										];
										$pdf = App::make('dompdf.wrapper');
										$pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
										->loadView('documents/warning-pdf', $data)
										->setPaper('a4', 'portrait');
										
										return $pdf->stream();
									}
									
									if ($document == 'cancel') {
										$data = [
											'cars' => $cars,
											'customer' => $customer,
										];
										$pdf = App::make('dompdf.wrapper');
										$pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
										->loadView('documents/cancel-pdf', $data)
										->setPaper('a4', 'portrait');
										
										return $pdf->stream();
									}
								}
								
								public function userNortify($id, Request $request)
								{
									$customer = DLTCustomer::find($id);
									$carSelected = $request->get('selected');
									$carprice = $request->get('price');
									
									foreach ($carSelected as $index => $carID) {
										$car = DLTCar::find($carID);
										
										if ($car->gps_stock()->exists()) {
											$firstChar = mb_substr($car->register_name, 0, 1);
											if ($firstChar == 0) {
												$char = mb_substr($car->register_name, 1, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											} else {
												$char = mb_substr($car->register_name, 0, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											}
											
											$cars[] = [
												'id' => $car->id,
												'unit_id' => $car->gps_stock[0]->unit_id,
												'install_date' => Carbon::parse($car->gps_stock()->withPivot('install_date')->first()->pivot->install_date)->format('d-m-Y'),
												'register_name' => $register_number,
												'register_chassi' => $car->register_chassi,
												'register_province' => $this->province_name($car->register_province),
												'register_make' => $car->register_make,
												'price' => $carprice[$index],
											];
										} else {
											$firstChar = mb_substr($car->register_name, 0, 1);
											if ($firstChar == 0) {
												$char = mb_substr($car->register_name, 1, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											} else {
												$char = mb_substr($car->register_name, 0, 2);
												$number = mb_substr($car->register_name, -4);
												$register_number = $char.'-'.$number;
											}
											
											$cars[] = [
												'id' => $car->id,
												'unit_id' => '',
												'install_date' => '-',
												'register_name' => $register_number,
												'register_chassi' => $car->register_chassi,
												'register_province' => $this->province_name($car->register_province),
												'register_make' => $car->register_make,
											];
										}
									}
									
									return view('sale/cancel-nortify', compact('customer', 'cars'));
								}
								
								public function createUserBaseOnParent($id, Request $request)
								{
									$userCreated = User::create([
										'username' => $request->get('username'),
										'name' => $request->get('name'),
										'email' => $request->get('email'),
										'tel' => $request->get('tel'),
										'line' => $request->get('line'),
										'password' => bcrypt($request->get('password')),
										'parent_user' => $id,
										'role' => 'user',
										'company_id' => 0,
										'server' => 'api.wetrustgps.com:7899',
										]);
										
										$jsonData = [
											'name' => $request->get('name'),
											'email' => $request->get('email'),
											'user_id' => $userCreated->id,
											'username' => $request->get('username'),
											'parent_user' => $id,
										];
										
										$json = json_encode($jsonData);
										
										$this->curlCreateUser($json);
										
										return redirect()->back();
									}
									
									public function parentUserAssignCarsView($id, Request $request)
									{
										$customer = DLTCustomer::find($id);
										$carsFind = DLTCar::where('owner_id', '=', $id)->get();
										
										foreach ($carsFind as $car) {
											if ($car->gps_stock()->exists()) {
												$firstChar = mb_substr($car->register_name, 0, 1);
												if ($firstChar == 0) {
													$char = mb_substr($car->register_name, 1, 2);
													$number = mb_substr($car->register_name, -4);
													$register_number = $char.'-'.$number;
												} else {
													$char = mb_substr($car->register_name, 0, 2);
													$number = mb_substr($car->register_name, -4);
													$register_number = $char.'-'.$number;
												}
												
												$cars[] = [
													'id' => $car->id,
													'unit_id' => $car->gps_stock[0]->unit_id,
													'install_date' => Carbon::parse($car->gps_stock()->withPivot('install_date')->first()->pivot->install_date)->format('d-m-Y'),
													'register_name' => $register_number,
													'register_chassi' => $car->register_chassi,
													'register_province' => $this->province_name($car->register_province),
													'register_make' => $car->register_make,
												];
											} else {
												$firstChar = mb_substr($car->register_name, 0, 1);
												if ($firstChar == 0) {
													$char = mb_substr($car->register_name, 1, 2);
													$number = mb_substr($car->register_name, -4);
													$register_number = $char.'-'.$number;
												} else {
													$char = mb_substr($car->register_name, 0, 2);
													$number = mb_substr($car->register_name, -4);
													$register_number = $char.'-'.$number;
												}
												
												$cars[] = [
													'id' => $car->id,
													'unit_id' => '',
													'install_date' => '-',
													'register_name' => $register_number,
													'register_chassi' => $car->register_chassi,
													'register_province' => $this->province_name($car->register_province),
													'register_make' => $car->register_make,
												];
											}
										}
										
										return view('sale/user-assign-cars', compact('customer', 'cars', 'id'));
									}
									
									public function parentUserAssignCars($id, Request $request)
									{
										$devices = [];
										$user_login_id = $request->get('sub-user');
										$devices['devices'] = $request->get('devices');
										
										// return  $devices;
										$json = json_encode($devices);
										$this->curlSenderDLT($user_login_id, $json);
										
										return redirect('/sale/show/'.$id);
									}
									
									public function curlSenderDLT($userID, $json)
									{
										$url = "http://api.wetrustgps.com:7899/api/assign-device-to-user/$userID";
										
										$curl = curl_init($url);
										curl_setopt($curl, CURLOPT_HEADER, false);
										curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
										curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
										curl_setopt($curl, CURLOPT_POST, true);
										curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
										
										$json_response = curl_exec($curl);
										curl_close($curl);
										
										return $json_response;
									}
									
									public function curlCreateUser($json)
									{
										$url = 'http://api.wetrustgps.com:7899/api/users/create';
										
										$curl = curl_init($url);
										curl_setopt($curl, CURLOPT_HEADER, false);
										curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
										curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
										curl_setopt($curl, CURLOPT_POST, true);
										curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
										
										$json_response = curl_exec($curl);
										curl_close($curl);
										
										return $json_response;
									}
									
									public function curlCreateQRCode($invoiceID, $amount)
									{
										$url = 'http://team.wetrustgps.com:3000/qr/'.$invoiceID.'/'.$amount;
										$curl = curl_init();
										curl_setopt_array($curl, array(
											CURLOPT_URL => $url,
											CURLOPT_RETURNTRANSFER => true,
											CURLOPT_ENCODING => '',
											CURLOPT_MAXREDIRS => 10,
											CURLOPT_TIMEOUT => 0,
											CURLOPT_FOLLOWLOCATION => true,
											CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
											CURLOPT_CUSTOMREQUEST => 'GET',
										));
										
										$response = curl_exec($curl);
										
										curl_close($curl);
										
										return $response;
									}
									
									public function insertINV($invoiceID, $customerID, $cars, $amount)
									{
										$customer = DLTCustomer::find($customerID);
										$today = Carbon::now();
										
										DB::table('invoices')->insert([
											'invoice_id' => $invoiceID,
											'cs_id' => $customerID,
											'cs_name' => $customer->name,
											'total_imei' => count($cars),
											'total_price' => $amount,
											'due_date' => $today->addDays(30)->format('Y-m-d'),
											'user_name' => Auth::user()->name,
											'created_at' => Carbon::now(),
											]);
											
											foreach ($cars as $key => $value) {
												
												DB::table('invoices_list_imei')->insert([
													'invoice_id' => $invoiceID,
													'imei' => $value['unit_id'],
													'for_year' => $value['for_year'],
													'created_at' => $today,
													]);
													
												}
												
												return 'Inserted';
											}
										}
										