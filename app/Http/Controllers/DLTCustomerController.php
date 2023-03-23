<?php

namespace App\Http\Controllers;

use App\DLTCar;
use Carbon\Carbon;
use App\DLTCustomer;
use Illuminate\Http\Request;

class DLTCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function unConfirm(Request $request){
        
        $query = urldecode($request->get('q'));
        
        if ($query) {
            $unConfirm = DLTCustomer::Where('citizen_id', 'LIKE', '%'.$query.'%')
            ->orWhere('name', 'LIKE', '%'.$query.'%')
            ->orWhere('business_name', 'LIKE', '%'.$query.'%')
            ->orWhere('tel', 'LIKE', '%'.$query.'%')
            ->where('status',1)
            ->paginate(25);
        } else {
            $unConfirm = DLTCustomer::where('confirm',0)->where('status',1)->orderBy('id', 'asc')->paginate(25);
        }
        
        $countUnConfirm = DLTCustomer::where('confirm',0)->count();
        $countConfirm = DLTCustomer::where('confirm',1)->count();
        
        return view('sale/unconfirm',compact('unConfirm','countConfirm','countUnConfirm'));
    }
    
    public function confirm(Request $request){
        $customer =  DLTCustomer::find($request->get('customer_id'));
        $customer->confirm = 1;
        $customer->confirm_date = Carbon::now()->format('Y-m-d');
        $customer->who_confirm = $request->user()->id;
        $customer->who_confirm_name = $request->user()->name;
        $customer->save();
        
        return redirect()->back();
    }
    
    public function updateCustomerAgent(Request $request){
        $customers =  DLTCustomer::whereNull('agent_name')->paginate(1000);
        
        foreach ($customers as $key => $customer) {
            
            $carsFind =  DLTCar::where('owner_id','=',$customer->id)->get();
            foreach ($carsFind as $car) {
                if($car->gps_stock()->exists()) {
                    $car->gps_stock[0]->agent_name;
                    $customer->agent_id = $car->gps_stock[0]->agent_use;
                    $customer->agent_name = $car->gps_stock[0]->agent_name;
                    $customer->save();
                }
            }
        }
        
        
        return $customers->links();
    }
}
