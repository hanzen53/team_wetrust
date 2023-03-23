<?php

namespace App\Http\Controllers;

use App\Device;
use App\User;
use Illuminate\Http\Request;
use App\DeviceStock;
use App\DLTCustomer;

class CRMController extends Controller
{
    public function __construct()
    {
        
    }
    
    
    public function dashboard(Request $request)
    {
        $query =  urldecode($request->get('q'));
        if($query){
            $usersV3 = User::where('name','LIKE', '%'.$query.'%')
            ->orWhere('username', 'LIKE', '%'.$query.'%')
            ->orWhere('email', 'LIKE', '%'.$query.'%')
            ->orWhere('line', 'LIKE', '%'.$query.'%')
            ->orWhere('tel', 'LIKE', '%'.$query.'%')
            ->get();

            $dltCustomer = DLTCustomer::where('name','LIKE', '%'.$query.'%')
            ->orWhere('tel', 'LIKE', '%'.$query.'%')
            ->orWhere('name_1', 'LIKE', '%'.$query.'%')
            ->orWhere('name_2', 'LIKE', '%'.$query.'%')
            ->orWhere('name_3', 'LIKE', '%'.$query.'%')
            ->orWhere('line_id', 'LIKE', '%'.$query.'%')
            ->orWhere('username', 'LIKE', '%'.$query.'%')
            ->orWhere('email', 'LIKE', '%'.$query.'%')
            ->get();
        }else{
            $usersV3 = [];
            $dltCustomer = [];
        }
        //return $users;
        return view('crm/dashboard',compact('usersV3','dltCustomer'));
    }
    
    public function carOwner(Request $request)
    {
        $query =  urldecode($request->get('q'));
        if($query){
            
            
            $carv3Search = Device::where('name','LIKE', '%'.$query.'%')
                                ->orWhere('uniqueId', 'LIKE', '%'.$query.'%')
                                ->get();
            
            $carSearch = DeviceStock::where('unit_id','LIKE', '%'.$query.'%')
            ->orWhere('installed_on_car', 'LIKE', '%'.$query.'%')
            ->get();
            
            if($carSearch){

                $dltCars = [];
                foreach ($carSearch as $key => $value) {
                    
                   
                    $firstChar = mb_substr($value->installed_on_car,0,1);
                    if($firstChar == 0){
                        $char = mb_substr($value->installed_on_car,1,2);
                        $number = mb_substr($value->installed_on_car,-4);
                        $register_number = $char.'-'.$number;
                        
                    }else{
                        $char = mb_substr($value->installed_on_car,0,2);
                        $number = mb_substr($value->installed_on_car,-4);
                        $register_number = $char.'-'.$number;
                    }
                    if($value->customer_id){
                        //return  DLTCustomer::find($value->customer_id)->tel;
                        $dltCars[] = [
                            'gps_stock_id' => $value->id,
                            'imei' => $value->unit_id,
                            'name' => $register_number,
                            'customer_id' => $value->customer_id,
                            'customer_name' => $value->customer_name,
                            'customer_tel' => DLTCustomer::find($value->customer_id)->tel
                        ];
                    }
                }


                $v3Cars = [];
                foreach ($carv3Search as $key => $value) {

                    $deviceV3 = Device::find($value->id);
                     //return  $deviceV3->users;

                     foreach ($deviceV3->users as $userValue) {
                        $v3Cars[] = [
                            'id' => $deviceV3->id,
                            'imei' => $deviceV3->uniqueId,
                            'name' => $deviceV3->name,
                            'customer_id' => $userValue->id,
                            'customer_name' => $userValue->name,
                            'customer_tel' => $userValue->tel,
                            'customer_username' => $userValue->username,
                            'customer_loginID' => $userValue->id,
                        ];
                     }

                }

            }else{
                $dltCars  = [];
                $v3Cars = [];
            }
            
        }else{
            $dltCars  = [];
            $v3Cars = [];
        }
        
       // return $v3Cars;
        return view('crm/car-owner',compact('dltCars','v3Cars'));
    }
}
