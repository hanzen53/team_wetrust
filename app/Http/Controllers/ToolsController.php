<?php

namespace App\Http\Controllers;

use App\DLTMasterFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToolsController extends Controller
{
    public function cancelIMEIs()
    {
        $imeis = DB::select("SELECT * FROM `cancel_imei`");

        foreach ($imeis as $imei){

            //return $imei->imei;

           $tran =  DB::table('device_stock')
                ->where('unit_id', '=',trim($imei->imei))
                ->update(['customer_status' => 0,'updated_at' => Carbon::now()]);


           echo  "Update ".$imei->imei." ".$tran."<br/>";
        }


        return "Updated";
    }

    public function repairZero()
    {
        $query = DB::select("SELECT * FROM `device_stock` WHERE `ID` > 10881 AND `gps_model` = 'TK116'");

        foreach ($query as $value) {
            $old = $value->unit_id;

            $tran =  DB::table('device_stock')
                ->where('unit_id', '=',trim($value->unit_id))
                ->update(['unit_id' => '0'.$old
                ]);


            echo  "Update ".$value->unit_id." ".$tran."<br/>";
        }
    }

    

}
