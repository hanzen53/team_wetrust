<?php

namespace App\Http\Controllers;

use App\DLTCustomer;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function __construct()
	{
		
	}
	
	public function dashboard(Request $request)
	{
		if(!Auth::check()){
			return redirect('/login');
		}
		$user = Auth::user();
		
		
		$query = urldecode($request->get('q'));
		if ($query) {
			$tickets = Ticket::where('subject', 'LIKE', "%$query%")
			->orWhere('content', 'LIKE', "%$query%")
			->orWhere('car_license', 'LIKE', "%$query%")
			->where('responder_id','=',$user->id)
			->orderBy('id', 'desc')
			->paginate(100);
		} else {
			$tickets = Ticket::where('team','=',$user->team)
			->where('responder_id','=',$user->id)
			->orderBy('id', 'desc')
			->paginate(100);
		}
		return view('tickets-dashboard', compact('tickets'));
	}
	
	public function listAll(Request $request)
	{
		$user = Auth::user();
		
		if(!Auth::check()){
			return redirect('/login');
		}

		$query = urldecode($request->get('q'));
		if ($query) {
			$tickets = Ticket::where('subject', 'LIKE', "%$query%")
			->orWhere('content', 'LIKE', "%$query%")
			->orWhere('car_license', 'LIKE', "%$query%")
			->paginate(100);
		} else {
			$tickets = Ticket::orderBy('id', 'desc')->paginate(100);
		}
		
		
		return view('tickets-dashboard', compact('tickets'));
		
		
		
	}
	
	
}