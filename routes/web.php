<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Device;
use App\DeviceStock;
use App\DeviesGPSPivot;
use App\DLTCar;
use App\DLTCustomer;
use App\DLTMasterFile;
use App\FindInstallDate;
use App\SimCard;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

Auth::routes();

Route::get('debug', function () {

   return Carbon::now()->timestamp;

});

Route::post('api/update-masterfile-dlt', 'DLTCarController@deviceLastUpdate');

Route::get('delete-duplicate-phone', function () {

    $tmpSIM = DB::select("SELECT phone_no, COUNT(*) c FROM simcard GROUP BY phone_no HAVING c > 1");

    foreach ($tmpSIM as $value) {

        try {
            $date = Carbon::parse($value->expire)->format('Y-m-d');

            echo $value->imei . ' ' . $date . "<br/>";

            DB::table('device_stock')
                ->where('unit_id', '=', trim($value->imei))
                ->update(['sim_expire_date' => $date]);
        } catch (\Exception $exception) {
            echo $exception;
        }

    }

    return "Done";
});

Route::get('select', function () {
    $device = DB::select("SELECT `uniqueId`,`install_date`,`next_billing`,`created_at` FROM device WHERE `install_date` BETWEEN '2017-11-10' AND '2017-11-20'");
    return $device_stock = DB::select("SELECT `unit_id`,`install_date`,`next_billing`,`created_at` FROM device_stock WHERE `install_date` BETWEEN '2017-11-10' AND '2017-11-20'");
});

Route::get('/', 'HomeController@index')->name('home');

Route::get('users/loginas/{id}', function ($id) {
    Auth::loginUsingId($id);

    return \redirect('http://center.wetrustgps.com');
});

/**
 *  API and Vue
 */

Route::get('/device-offline', 'VueController@deviceOffline');
//Route::get('/device-status','VueController@deviceStatus');
Route::get('/device-status', 'DeviceManageController@deviceStatus');
Route::get('/vue-debug', 'VueController@vueDebug');

Route::get('/wox-csv', 'CSVController@index');

/**
 * Device status
 */
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    /**
     * DLT Car
     */
    Route::get('/dlt-car-add/{dlt_customer_id}', 'DLTCarController@addCarView');
    Route::post('/dlt-car-add/{dlt_customer_id}', 'DLTCarController@addCar');
    Route::get('/dlt-car-show/{car_id}', 'DLTCarController@carShow');
    Route::post('/dlt-car-update/{car_id}', 'DLTCarController@carUpdate');

    /**
     * DLT Stock
     */
    Route::get('/device-stock', 'DeviceStockController@index');
    Route::get('/device-stock/create', 'DeviceStockController@create');
    Route::post('/device-stock', 'DeviceStockController@store');
    Route::get('/device-stock/show/{id}', 'DeviceStockController@show');
    Route::post('/device-stock/show/{id}', 'DeviceStockController@update');
    Route::post('/device-stock/delete/{id}', 'DeviceStockController@destroy');

    Route::post('/update-sim/{id}', 'DeviceStockController@simUpdate');

    Route::get('/sim-will-expire', 'DeviceStockController@simWillExpire');

    Route::get('/device-stock-to-agent', 'DeviceStockController@stockToAgent');

    /**
     * Payment history
     */
    Route::get('/payment-list', 'DeviceStockController@paymentList');
    Route::get('/payment-list-old', 'DeviceStockController@paymentListOld');
    Route::get('/payment-list-all', 'DeviceStockController@paymentListAll');
    Route::get('/payment/{imei}', 'DeviceStockController@paymentIMEI');
    Route::post('/payment/{imei}', 'DeviceStockController@paymentIMEIstore');
    Route::get('/paid-list', 'DeviceStockController@paidList');
    Route::get('/payment-history', 'DeviceStockController@paymentHistory');

    Route::get('/paid-import-fix', function () {
        $data = DB::select("SELECT imei,paid_date FROM payment_history WHERE next_paid IS NULL");

        foreach ($data as $value) {
            $nextBill = Carbon::parse($value->paid_date)->addDays(365);
            DB::table('payment_history')
                ->where('imei', '=', $value->imei)
                ->update(['next_paid' => $nextBill]);
        }
    });

    /**
     * Technician
     */
    Route::get('/technician/upload-images', 'TechnicianController@uploadForm');

    /**
     * Call center & after sale service
     */
    Route::get('/crm/call-center', 'CRMController@dashboard');
    Route::get('/crm/car-owner', 'CRMController@carOwner');
    Route::get('/crm/list-all-ticket', 'DashboardController@listAll');

    /**
     * Ticket system
     */
    Route::get('/user/ticket-list/{user_id}', 'TicketController@userTicketAll');
    Route::get('/user/ticket/create/{user_id}', 'TicketController@createTicket');
    Route::post('/user/ticket/create/', 'TicketController@storeTicket');
    Route::get('/user/ticket/detail/{id}', 'TicketController@showTicket');

    Route::post('/user/ticket/create/note/{id}', 'TicketController@storeNote');
    Route::post('/user/ticket/update/{id}', 'TicketController@updateTicket');

    /**
     * Car And GPS assign
     */
    Route::get('/gps/assign/{id}', 'DLTCarController@assignGPS');
    Route::post('/gps/assign/{id}', 'DLTCarController@assignGPSPOST');
    Route::post('/gps/un-assign', 'DLTCarController@unAssignGPS');

    /**
     * Sale or DLTCustomer
     */
    Route::get('/sale/dashboard', 'SaleController@dashboard');
    Route::get('/sale/create', 'SaleController@create');
    Route::post('/sale/create', 'SaleController@store');
    Route::get('/sale/show/{id}', 'SaleController@show');
    Route::get('/sale/update/{id}', 'SaleController@edit');
    Route::post('/sale/update/{id}', 'SaleController@update');
    Route::get('/sale/delete/{id}', 'SaleController@destroy');

    Route::get('/sale/quick', 'SaleController@quick');
    Route::post('/sale/quick', 'FilesAndImageController@quickUploadFile');

    Route::get('/sale/un-key', 'SaleController@unKey');
    Route::get('/sale/un-key/{citizen_id}', 'SaleController@unKeyShow');
    Route::get('/sale/mark-to-done/{id}', 'SaleController@markTodone');

    Route::get('/sale/user-invoice/{id}', 'SaleController@userInvoice');
    Route::post('/sale/user-invoice/{id}', 'SaleController@userInvoicePost');

    Route::get('/sale/user-nortify/{id}', 'SaleController@userNortify');

    Route::post('/create-user/parent/{id}', 'SaleController@createUserBaseOnParent');
    Route::get('/parent-user-assign-car/{id}', 'SaleController@parentUserAssignCarsView');
    Route::post('/parent-user-assign-car/{id}', 'SaleController@parentUserAssignCars');

    /**
     * Create car on API server
     */
    Route::post('/create-car-on-api', 'DeviceManageController@createCarOnAPI');

    /**
     * User line token
     */
    Route::get('/add-line-token', 'LineTokenController@addLineToken');
    Route::post('/add-line-token', 'LineTokenController@sendData');

    /**
     * DLT Certificate
     */
    Route::get('/dlt/certificate/{id}', 'DLTCarController@dltCertificate');

    /**
     * Upload file and images
     */
    Route::post('/upload-data', 'FilesAndImageController@storeFilesOrImages');
    Route::get('/delete-data/{id}', 'FilesAndImageController@deleteFilesOrImages');

    /**
     * Task list
     */
    Route::get('/tasks/dashboard', 'DashboardController@dashboard');

    /**
     * Get raw file
     */

    Route::get('/raw-file', 'RawFileExportController@rawFileView');

    /**
     * Auto ticket
     */
    //Route::post('/auto-ticket','TicketController@autoTicket');

    /**
     * Set forward to GPSwox
     */

    Route::get('/forward-2-lite', 'DeviceManageController@forwardWox');
    Route::post('/forward-2-lite', 'DeviceManageController@forwardWoxPOST');

    Route::post('/do-space-upload', 'DOSpaceController@uploadFile');

    Route::get('/release-imei', 'DeviceManageController@releaseIMEI');
    Route::post('/release-imei', 'DeviceManageController@releaseIMEIPOST');

    /**
     * Assign Cars
     */

    Route::get('/assign-devices/{user_id}/{user_login_id}', 'DeviceManageController@updateAssignCar');

});

/**
 * Login
 */
Route::post('login', function (Request $request) {

    if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password'), 'employee_active' => 1])) {
        if (Auth::check()) {

            return Redirect::to('/home');

        }
    } else {
        return redirect('/login');
    }
});

Route::get('/register', function () {
    return redirect('/login');
});

Route::get('api/servers', 'APIController@get_server');

Route::domain('report.gps-v4-center.dev')->group(function () {
    Route::get('user/{id}', function ($id) {
        return ['id' => $id];
    });
});

Route::post('post-master-file', 'DLTCarController@postMasterFile');

Route::get('/edit-plate', 'DLTCarController@editPlate');
Route::post('/edit-plate', 'DLTCarController@updatePlate');

Route::get('/update-speed-limit', 'DLTCarController@updateSpeed');
Route::post('/update-speed-limit', 'DLTCarController@postUpdateSpeed');

Route::get('/manual-sent-dlt', 'DLTCarController@manualSentDLT');
Route::post('/manual-sent-dlt', 'DLTCarController@manualSentDLTPOST');

Route::post('/raw-file-csv', 'CSVController@generateCSV');

Route::get('/create-device', 'CreateDeviceOnMongodbController@create');

Route::post('/dlt-customer-note', 'SaleController@dltCustomerNote');

Route::get('/become-billing', 'SaleController@dltCustomerNote');

Route::get('/tpi-job', 'TPIController@openJob');
Route::get('/tpi-search-area', 'TPIController@searchData');

Route::post('/tpi-create-job', 'TPIController@createJob');

Route::get('/user/profile', 'UserManagementController@profile');
Route::post('/user/profile', 'UserManagementController@profileUpdate');

Route::get('/list-all-car', 'DLTCarController@listAllCars');
Route::get('/list-all-mf', 'DLTCarController@listAllMF'); //?update=1
Route::get('/list-all-mf-offline', 'DLTCarController@listAllMFOffline');

Route::get('/update-master-file-owner', 'DLTCarController@updateMasterFileOwner');

Route::get('/mf-note/{imei}', 'DLTCarController@mfNote');

Route::get('/allow-dlt/{imei}', 'DLTCarController@allowDLT');
Route::get('/block-dlt/{imei}', 'DLTCarController@blockDLT');
Route::get('/dlt-master-file-delete/{imei}', 'DLTCarController@deleteMasterFileToDLTServer');

/**
 * Device stock management
 */

Route::get('/device-stock-used', 'DeviceStockController@deviceUsed');
Route::get('/device-stock-unused', 'DeviceStockController@deviceUnUsed');
Route::get('/device-stock-unused-run-on-v3', 'DeviceStockController@deviceUnUsedRunOnV3');
Route::get('/update-run-on-v3/{imei}', 'DeviceStockController@updateRunOnV3');
Route::get('/assign-stock-to-agent', 'DeviceStockController@deviceForAgentView');
Route::post('/assign-stock-to-agent', 'DeviceStockController@deviceForAgent');

Route::post('/device-stock-cancel', 'DeviceStockController@deviceCancel');

Route::get('/update-tmp-unuse-v3', 'DeviceStockController@updateUnuseV3');

Route::get('/device-canceled', 'DeviceStockController@indexIMEICanceled');
Route::post('/device-canceled', 'DeviceStockController@cancelIMEI');

Route::get('/mark-delete-realtime-db', 'DeviceStockController@cancelIMEIRealTimeDB');

/**
 * Agents
 */
Route::get('/agents', 'AgentController@index');
Route::get('/agents/create', 'AgentController@create');
Route::post('/agents', 'AgentController@store');

Route::get('/agent/{id}/edit', 'AgentController@edit');
Route::get('/agent/show/{id}', 'AgentController@edit');
Route::post('/agent/{id}', 'AgentController@update');

Route::get('/fix-imei', function () {
    $devices = DB::select("select gps_stock_id from device_gps where imei IS NULL limit 100");

    foreach ($devices as $device) {
        $deviceStock = DeviceStock::find($device->gps_stock_id);

        try {
            $affected = DB::table('device_gps')->where('gps_stock_id', '=', $device->gps_stock_id)->update(['imei' => $deviceStock->unit_id]);
        } catch (Exception $exception) {

        }

    }
});

Route::get('/devices-stock-install', function () {

    $deicesStock = DB::select('SELECT * FROM `device_stock` WHERE `customer_id` IS NULL AND `used` = 1 LIMIT 500');

    foreach ($deicesStock as $device) {

        $mapped = DeviesGPSPivot::where('gps_stock_id', '=', $device->id)->first();
        $car = DLTCar::find($mapped->dlt_car_id);
        if ($car) {
            $customer = DLTCustomer::find($car->owner_id);

            if ($customer->business_name != '') {
                $customer_name = $customer->business_name;
            } else {
                $customer_name = $customer->name;
            }

            $deicesStockUpdate = DeviceStock::find($device->id);
            $deicesStockUpdate->installed_on_car = $car->register_name;
            $deicesStockUpdate->customer_id = $customer->id;
            $deicesStockUpdate->customer_name = $customer_name;
            $deicesStockUpdate->install_date = $mapped->install_date;
            $deicesStockUpdate->next_billing = Carbon::parse($mapped->install_date)->addDays(365);

            $deicesStockUpdate->save();
        }

    }

    return "DONE";

});

Route::get('/update-address', 'ConvertAddressController@updateAddress');

/**
 * Tools
 */
Route::get('/update-cancel-imei', 'ToolsController@cancelIMEIs');
Route::get('/repair-zero', 'ToolsController@repairZero');

/**
 * DLT Master update
 */
Route::get('/pull-masterfile-dlt', 'DLTCarController@pullMasterFileDLT');

Route::get('/php-info', function () {

    phpinfo();
});

Route::get('/xml', function () {
    $xml = "<info><sat>7</sat><sequence>3</sequence><distance>0</distance><totaldistance>11739361.82</totaldistance><motion>false</motion><valid>true</valid><enginehours>49583</enginehours><status>69</status><ignition>false</ignition><charge>true</charge><blocked>false</blocked><batterylevel>0</batterylevel><rssi>30</rssi></info>";
    $data = simplexml_load_string($xml);

    // print_r($data);
    echo $data[0]->ignition;
});

Route::get('/update-expire-sim', function () {
    $tmpSim = DB::select("SELECT * FROM `tmp_sim` where `is_update` = 0 and `expire` != '#N/A' LIMIT 500");
    // return Carbon::parse('20190104')->format('Y-m-d');

    foreach ($tmpSim as $sim) {
        SimCard::where('phone_no', '=', $sim->sim)->update([
            'expire_date' => Carbon::parse($sim->expire)->format('Y-m-d'),
        ]);

        DB::table('tmp_sim')
            ->where('id', $sim->id)
            ->update(['is_update' => 1]);
    }

    return 'Done';

});

Route::get('/update-install_date-from-device_gps-to-device_stock', function () {
    $device_gps = DB::select("SELECT * FROM `device_gps`");

    foreach ($device_gps as $dvs) {

        DB::table('device_stock')
            ->where('id', $dvs->gps_stock_id)
            ->update(['install_date' => $dvs->install_date]);
    }

    return 'Done';

});

Route::get('update-sim-to-device-stock', function () {
    return $simcards = DB::select("SELECT * FROM `simcard` where id > 33428 ");

    foreach ($simcards as $key => $sim) {

        $stockID = DB::select("SELECT * FROM `device_stock` WHERE `phone_number` =  '$sim->phone_no' ");

        if ($stockID) {

            $stockUpdate = DeviceStock::find($stockID[0]->id);
            $stockUpdate->simcard_id = $sim->id;
            $stockUpdate->migrated = 1;
            $stockUpdate->save();
        }
    }
    return "Done";
});

Route::get('update-device-stock-to-sim', function () {
    $sims = DB::select("SELECT * FROM `simcard` WHERE `migrated` = 0 LIMIT 2000");

    foreach ($sims as $key => $sim) {

        $stockID = DB::select("SELECT `id`,`phone_number`,`unit_id` FROM `device_stock` WHERE `phone_number` =  '$sim->phone_no' LIMIT 1");
        if ($stockID) {
            $simUpdate = SimCard::find($sim->id);
            $simUpdate->stock_id = $stockID[0]->id;
            $simUpdate->migrated = 1;
            $simUpdate->save();
        }
    }

    return "Done";

});

/**
 * Update sim from google sheets
 */
Route::get('udate-sim-from-google-sheets', function () {

    $apiKey = 'AIzaSyDwpgqnzunTlKuHqBArzo1bdUT6d5zVTCA';
    $dataURI = 'https://sheets.googleapis.com/v4/spreadsheets/1Igch2SWrmsuCOB0pr4Hcd0VKUDpzKCHcNjvTh9cIDdc/values/sim-true?majorDimension=ROWS&key=' . $apiKey;
    $data = file_get_contents($dataURI);

    $dataJsonDecode = json_decode($data, true);
    $loop = 0;
    $dataArray = [];

    foreach ($dataJsonDecode['values'] as $data) {

        if ($loop != 0) {

            $simResualt = SimCard::where('phone_no', $data[0])->first();

            if ($simResualt) {
                $simResualt->balance = $data[1];
                $simResualt->expire_date = $data[2];
                $simResualt->save();
            } else {
                SimCard::create([
                    'phone_no' => $data[0],
                    'balance' => $data[1],
                    'expire_date' => $data[2],
                    'operator' => $data[3],
                ]);
            }
        }

        $loop++;
    }
    return "Done";
});

/**
 * Update SIM data from simcard table to device stock
 */
Route::get('update-sim-to-device-stock', function (Request $request) {

    $simCards = DB::table('simcard')
        ->whereNotNull('stock_id')
        ->paginate(2000);

    foreach ($simCards as $key => $value) {
        DB::table('device_stock')
            ->where('id', $value->stock_id)
            ->update([
                'phone_number' => $value->phone_no,
                'operator' => $value->operator,
                'sim_expire_date' => $value->expire_date,
                'updated_at' => Carbon::now(),
            ]);
    }

    return $simCards->links();
});
/**
 * Update Device stock data table to SIM stock
 */
Route::get('update-device-stock-to-sim', function (Request $request) {

    $deviceStock = DB::table('device_stock')
        ->whereNull('phone_number')
        ->whereNotNull('simcard_id')
        ->paginate(10);

    foreach ($deviceStock as $key => $value) {
        DB::table('simcard')
            ->where('id', $value->simcard_id)
            ->update([
                'stock_id' => $value->id,
            ]);
    }

    return $deviceStock->links();
});

/**
 * Find install date
 */

Route::get('find-install-date', function (Request $request) {
    $data = [
        "044074482382",
        "044074493173",
    ];

    foreach ($data as $key => $value) {
        $device = Device::where('uniqueId', '=', $value)->first();
        if ($device) {
            FindInstallDate::updateOrCreate([
                'imei' => $device->uniqueId,
                'name' => $device->name,
                'created_date' => $device->created_at,
            ]);
        } else {
            echo '"' . $value . '",';
        }
    }

    return "Done";
});

Route::get('delete-imei-fah', function (Request $request) {
    $data = [
        "44070489324",
    ];

    foreach ($data as $key => $value) {
        try {
            DB::table('device')->where('uniqueId', '=', $value)->delete();
            DB::table('device_stock')->where('unit_id', '=', $value)->delete();
        } catch (\Throwable $th) {

        }

    }

    return "Done";

});

Route::get('update-agent', function (Request $request) {

    $data = [
        "044070488862",
        "864507031206708",

    ];

    foreach ($data as $key => $value) {

        try {
            DB::table('device_stock')->where('unit_id', '=', $value)
                ->update([
                    'used' => 1,
                    'agent_use' => 14,
                    'agent_name' => 'WeTrustGPS',

                ]);
        } catch (\Throwable $th) {
            echo "Error " . $value . "<br/>";
        }

    }

    return "Done";
});

Route::get('find-not-in-imei', function () {

    $device_stock = DB::table('device_stock')
        ->select('unit_id')
        ->paginate(2000);

    foreach ($device_stock as $key => $value) {

        DB::table('device')
            ->where('uniqueId', $value->unit_id)
            ->update([
                'on_stock' => 1,
            ]);
    }
    return $device_stock->links();
});

Route::get('/list-car-on-server', 'ServerController@index');
Route::get('/reboot-server', 'ServerController@rebootServer');
Route::post('/reboot-server', 'ServerController@rebootServerAction');

Route::get('/update-stock-id', 'ServerController@updateStockID');

Route::get('/confirm-customer', 'DLTCustomerController@unConfirm');
Route::post('/confirm-customer', 'DLTCustomerController@confirm');

/**
 * ยังไม่มีเจ้าของ
 */

Route::get('/unknow-owner', 'DeviceStockController@unkonwOwner');

/**
 * Run update customer agent
 */
Route::get('/update-agent-to-customer', 'DLTCustomerController@updateCustomerAgent');

Route::get('/update-pivot-imei', 'DeviceStockController@updatePivotImei');
/**
 * Update piad
 */
Route::get('/update-paid-on-install/{year}', 'DeviceStockController@updatePaidInstall');
Route::get('/update-next-billing', 'DeviceStockController@updateNextBilling');

Route::get('/update-owner-on-mf', function () {

    $mfData = DLTMasterFile::whereNull('customer_name')->get();

    foreach ($mfData as $key => $value) {
        $deviceStockData = DeviceStock::where('unit_id', $value->imei)->first();
        //return $deviceStockData['customer_name'];
        DB::table('dlt_master_file')
            ->where('imei', $value->imei)
            ->update([
                'customer_id' => $deviceStockData['customer_id'],
                'customer_name' => $deviceStockData['customer_name'],
            ]);
    }

    return "Done";
});

Route::get('list-images', 'FilesAndImageController@listImage');

/**
 * Line app
 */
Route::get('liff-app', 'LineAppController@liffApp');
Route::get('realtime-tracking/{imei}', 'LineAppController@realTimeTracking');
Route::get('scan-me/{imei}', 'LineAppController@scanme');

Route::post('check-login','LineAppController@checkLogin')->middleware('cors');



/**
 * Delete imei unuse
 */
Route::get('delete-unuse-imei',function(){
    $deleteIMEI = DB::table('device_cancel')->where('confirm',0)->take(1000)->get();

    foreach ($deleteIMEI as $key => $value) {
        //return $value->imei;
        DB::table('device')->where('uniqueId',$value->imei)->delete(); //12564
        DB::table('device_stock')->where('unit_id',$value->imei)->delete();//14266
        DB::table('device_gps')->where('imei',$value->imei)->delete();//9318

        DB::table('device_cancel')->where('imei',$value->imei)->update(['confirm'=> 1]);
    }

    return "Done";

  
});