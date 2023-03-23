<?php

namespace App\Http\Controllers;

use App\Device;
use App\DLTCar;
use App\Ticket;
use App\TicketAttribute;
use App\TicketImage;
use App\TicketNote;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{
    public function __construct()
    {
     //$this->middleware('admin',['except' => ['autoTicket']]);
    }
    
    /**
     * List ticket
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userTicketAll($user_id,Request $request)
    {
        
        $tickets = Ticket::where('user_id','=',$user_id)->get();
        $user = User::find($user_id);
//        $cars = $user->devices()->get();
        $carsFind =  DLTCar::where('owner_id','=',$user_id)->get();
		$cars = [];
        foreach ($carsFind as $car) {

            if($car->gps_stock()->exists()) {

                $firstChar = mb_substr($car->register_name, 0, 1);
                if ($firstChar == 0) {
                    $char = mb_substr($car->register_name, 1, 2);
                    $number = mb_substr($car->register_name, -4);
                    $register_number = $char . '-' . $number;

                } else {
                    $char = mb_substr($car->register_name, 0, 2);
                    $number = mb_substr($car->register_name, -4);
                    $register_number = $char . '-' . $number;
                }


                $cars[] = [
                    'id' => $car->id,
                    'unit_id' => $car->gps_stock[0]->unit_id,
                    'install_date' => Carbon::parse($car->gps_stock()->withPivot('install_date')->first()->pivot->install_date)->format('d-m-Y'),
                    'register_name' => $register_number,
                    'register_chassi' => $car->register_chassi,
                    'register_make' => $car->register_make,
                ];
            }
        }


       // return $cars
        
        return view('crm/tickets',compact('tickets','user','cars'));
    }
    
    /**
     * Create new ticket for user
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param Request $request
     * @internal param $user_id
     */
    public function createTicket($user_id,Request $request)
    {
        $ticketPriority = TicketAttribute::where('type','=','priority')->get();
        $ticketTeam = TicketAttribute::where('type','=','team')->get();
		$usersTeam = User::where('user_type','=','employee')
		->where('employee_active',1)
		->get();
		$name = $request->get('name');

        return view('crm/create',compact('user_id','ticketPriority','ticketTeam','usersTeam','name'));
    }
    
    /**
     * Store new ticket
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeTicket(Request $request)
    {

		$staff =  Auth::user();

		$responder =  $request->get('responder');
		$responder = explode(',',$responder);
		$responderID = $responder[0];
		$responderName = $responder[1];

        $ticketID = Ticket::create([
            'subject' => $request->get('subject'),
            'car_license' => $request->get('car_license'),
            'content' => $request->get('content'),
            'status' => 'S01',
            'user_id' => $request->get('user_id'),
            'call_center_id' => $staff->id,
            'call_center_name' => $staff->name,
            'responder_id' => $responderID,
            'responder_name' => $responderName,
            'team' => $request->get('team'),
            'priority' => $request->get('priority'),
        ]);

		$notify = [
			'ticket_id' => $ticketID->id,
			'content' => $request->get('content'),
			'who_notes' => $staff->name
		];

		$notify = json_encode($notify);

		//$this->lineNotify($notify);
    
    
        if($request->file('file_1')){
            $file1     = $request->file('file_1');
            $file_name  = $ticketID->id.'_'.$file1->getClientOriginalName();
            $file1_path       = $file1->move('uploads/tickets/', $file_name);
            
            TicketImage::create([
                'who_upload' => Auth::user()->id,
                'ticket_id' => $ticketID->id,
                'file_name' => $file_name,
                'path' => $file1_path,
            ]);
        }
        if($request->file('file_2')){
            $file2     = $request->file('file_2');
            $file2_name = $ticketID->id.'_'.$file2->getClientOriginalName();
            $file2_path      = $file2->move('uploads/tickets/', $file2_name);
    
            TicketImage::create([
                'who_upload' => Auth::user()->id,
                'ticket_id' => $ticketID->id,
                'file_name' => $file2_name,
                'path' => $file2_path,
            ]);
    }
        if($request->file('file_3')){
            $file3     = $request->file('file_3');
            $file3_name = $ticketID->id.'_'.$file3->getClientOriginalName();
            $file3_path      = $file3->move('uploads/tickets/', $file3_name);
    
            TicketImage::create([
                'who_upload' => Auth::user()->id,
                'ticket_id' => $ticketID->id,
                'file_name' => $file3_name,
                'path' => $file3_path,
            ]);
        }

        return redirect('/user/ticket-list/'.$request->get('user_id'));
    }
    
    /**
     * Show ticket detail
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTicket($id)
    {
        $ticket = Ticket::find($id);
        $ticketImages = TicketImage::where('ticket_id','=',$id)->get();
        $notes = TicketNote::where('ticket_id','=',$id)->get();
        $ticketStatus = TicketAttribute::where('type','=','status')->get();
        $ticketPriority = TicketAttribute::where('type','=','priority')->get();
        $ticketTeam = TicketAttribute::where('type','=','team')->get();
		$usersTeam = User::where('user_type','=','employee')
		->where('employee_active',1)
		->get();
        
        return view('crm/show',compact('ticket','ticketImages','notes','ticketStatus','ticketPriority','ticketTeam','usersTeam'));
    }
    
    /**
     * Store note
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeNote($id,Request $request)
    {
        $content = $request->get('content');
    	TicketNote::create([
            'ticket_id' => $id,
            'content' => $content,
            'who_notes' => Auth::user()->id,
        ]);

        $notify = [
        	'ticket_id' => $id,
			'content' => $content,
			'who_notes' => Auth::user()->name
		];

		$notify = json_encode($notify);

		$this->lineNotify($notify);
        
        return redirect()->back();
    }
    
    
    public function updateTicket($id,Request $request)
    {

		$responder =  $request->get('responder');

		if($responder != 0) {

			$responder = explode(',', $responder);
			$responderID = $responder[0];
			$responderName = $responder[1];

			$ticketStatus = $request->get('status');

			if ($ticketStatus == 'S03') {
				$statusContent = "แจ้งปิดงาน";
			} else {
				$statusContent = "มีการเปลี่ยนแปลงข้อมูล หรือ สถานะ";
			}


			//return $request->all();
			$ticket = Ticket::find($id);
			//$ticket->subject = $request->get('subject');
			//$ticket->content = $request->get('content');
			$ticket->team = $request->get('team');
			$ticket->priority = $request->get('priority');
			$ticket->status = $request->get('status');
			//$ticket->user_id = $request->get('status');
			//		$ticket->responder_id = Auth::user()->id;
			//		$ticket->responder_name  = Auth::user()->name;

			if ($ticketStatus == 'S03') {
				$ticket->responder_id = Auth::user()->id;
				$ticket->responder_name = Auth::user()->name;
			} else {
				$ticket->responder_id = $responderID;
				$ticket->responder_name = $responderName;
			}

			$ticket->save();

			$notify = [
				'ticket_id' => $id,
				'content' => $statusContent,
				'who_notes' => Auth::user()->name
			];

			$notify = json_encode($notify);

			$this->lineNotify($notify, 1);
		}else{
			Session::flash("error","กรุณาเลือกผู้รับผิดชอบงาน");
		}
        
        return redirect()->back();
    }


	public function lineNotify($data,$close = 0)
	{

		$token = 'sCEHV0swKQs90BBB9KQLf5tW9soKEx5JeeDX1ScQywF';
		//$token = 'AjbegPxmuM5S5zgmJ5KmNoUAzVL18qhf85ttbw78Sk9';
		$data = json_decode($data,true);
		$content = strip_tags($data['content']);
		$content = str_replace('&nbsp;',' ',$content);
		$message = '';

		if($close == 0){
			$message .= "\n Ticket ID: "
				.$data['ticket_id']
				."\n"
				."Link: \n"
				.'http://team.wetrustgps.com/user/ticket/detail/'.$data['ticket_id']
				."\n\n"
				."ข้อความ: \n"
				.$content
				."\n\n"
				.'จาก:'
				."\n"
				.$data['who_notes']
				."\n";
		}else{
			$message .= "\n Ticket ID: "
				.$data['ticket_id']
				."\n"
				."Link: \n"
				.'http://team.wetrustgps.com/user/ticket/detail/'.$data['ticket_id']
				."\n\n"
				."ข้อความ: \n"
				.$content
				."\n\n"
				.'จาก:'
				."\n"
				.$data['who_notes']
				."\n";
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://notify-api.line.me/api/notify",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"message\"\r\n\r\n$message\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
			CURLOPT_HTTPHEADER => array(
				"authorization: Bearer $token",
				"cache-control: no-cache",
				"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
				"postman-token: 658ee9ed-9ed3-6c8d-9d75-ba094a8acdcd"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

//			if ($err) {
//				echo "cURL Error #:" . $err;
//			} else {
//				echo $response;
//			}
    }


	/**
	 * Store new ticket
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function autoTicket(Request $request)
	{



		$responderStaff = [2789,2729];

		$userRan = array_rand($responderStaff);
		$randID = $responderStaff[$userRan];
		$staff =  User::find($randID);

		$responderID = $staff->id;
		$responderName = $staff->name;

		$unit = Device::where('uniqueId','=',trim($request->get('unit_id')))->first();

		$title = $unit->name." (".$request->get('alert').")";
		$content = $unit->name." IMEI ".$request->get('unit_id')." ".$request->get('alert');

		$ticket = Ticket::where('subject','=',$title)->get();

		if(count($ticket) < 1) {

			$ticketID = Ticket::create([
				'subject' => $title,
				'car_license' => $unit->name,
				'content' => $content,
				'status' => 'S01',
				'user_id' => 739,
				'call_center_id' => 2787,
				'call_center_name' => 'Kokarat',
				'responder_id' => $responderID,
				'responder_name' => $responderName,
				'team' => 'T05',
				'priority' => 'P03',
			]);

			$notify = [
				'ticket_id' => $ticketID->id,
				'content' => $title,
				'who_notes' => "System Robot"
			];

			$notify = json_encode($notify);

			//$this->lineNotify($notify);

			return "Created";
		}else{
			return "Existing issue";
		}
	}

}
