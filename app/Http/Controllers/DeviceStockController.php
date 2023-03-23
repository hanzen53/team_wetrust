<?php

namespace App\Http\Controllers;

use App\Agent;
use App\CancelIMEI;
use App\Device;
use App\DeviceStock;
use App\PaymentHistory;
use App\TempDeviceUnUse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeviceStockController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        if ($request->get('search')) {
            $search = $request->get('search');
            $stock = DeviceStock::where('unit_id', 'LIKE', '%' . $search . '%')
                ->orwhere('make', 'LIKE', '%' . $search . '%')
                ->orwhere('gps_model', 'LIKE', '%' . $search . '%')
                ->orwhere('dlt_type', 'LIKE', '%' . $search . '%')
                ->orwhere('dlt_style', 'LIKE', '%' . $search . '%')
                ->orwhere('who_add', 'LIKE', '%' . $search . '%')
                ->orwhere('phone_number', 'LIKE', '%' . $search . '%')
                ->orderby('id', 'desc')
                ->paginate(50);
        } else {
            $stock = DeviceStock::orderby('id', 'desc')->paginate(50);
        }

        $total = DB::select("SELECT COUNT(id) AS `total` FROM `device_stock`");
        $used = DB::select("SELECT COUNT(`used`) AS `used` FROM `device_stock` WHERE `used` = 1");
        $available = DB::select("SELECT COUNT(`used`) AS `available` FROM `device_stock` WHERE `used` = 0");
        $agentUse = DB::select("SELECT COUNT(`agent_use`) AS `agent_use` FROM `device_stock` WHERE `agent_use` != 14");

        $stat = [$used[0], $available[0], $agentUse[0]];

        //        return $stat[1]->available;

        return view('device-stock/index', compact('stock', 'stat', 'total'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexIMEICanceled(Request $request)
    {

        if ($request->get('search')) {
            $search = $request->get('search');

            $deviceCanceled = CancelIMEI::where('name', 'LIKE', '%' . $search . '%')
                ->orwhere('imei', 'LIKE', '%' . $search . '%')
                ->orwhere('gps_model', 'LIKE', '%' . $search . '%')
                ->orwhere('sim_no', 'LIKE', '%' . $search . '%')
                ->orderby('id', 'desc')
                ->paginate(50);
        } else {
            $deviceCanceled = CancelIMEI::orderby('id', 'desc')->paginate(50);
        }

        return view('device-stock/index-devices-cancel', compact('deviceCanceled'));
    }

    public function cancelIMEI(Request $request)
    {
        // return $request->all();

        $imei = DeviceStock::where('unit_id', '=', trim($request->get('imei')))->first();

        CancelIMEI::create([
            'name' => trim($request->get('name')),
            'imei' => trim($request->get('imei')),
            'gps_model' => $imei->gps_model,
            'sim_operator' => $imei->operator,
            'sim_no' => $imei->phone_number,
            'install_date' => $imei->installed_on_car,
            'agent' => $imei->agent_name,
            'customer_name' => $imei->customer_name,
            'car_type' => trim($request->get('car_type')),
            'cancel_date' => trim($request->get('cancel_date')),
            'note' => trim($request->get('note')),
            'staff_id' => $request->user()->id,
            'staff_name' => $request->user()->name,
        ]);

        return redirect()->back();
    }

    public function cancelIMEIRealTimeDB(Request $request)
    {
        // return $request->all();

        $imei = DeviceStock::where('unit_id', '=', trim($request->get('imei')))->first();
        $user = Auth::user();

        CancelIMEI::create([
            'name' => $request->get('name'),
            'imei' => $request->get('imei'),
            // 'gps_model' => $imei->gps_model,
            // 'sim_operator' => $imei->operator,
            'sim_no' => $request->get('tel'),
            // 'install_date' => $imei->installed_on_car,
            // 'agent' => $imei->agent_name,
            // 'customer_name' => $imei->customer_name,
            //'car_type' => trim($request->get('car_type')),
            'cancel_date' => Carbon::now()->format('Y-m-d'),
            //'note' => trim($request->get('note')),
            'staff_id' => $user->id,
            'staff_name' => $user->name,
        ]);

        return view('device-stock/delete-done', compact('imei'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('device-stock/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {

        //return $request->all();

        $valid = $request->validate([
            'gps_model' => 'required',
            'unit_id' => 'required',
        ]);

        if ($valid) {
            $gpsModel = $request->get('gps_model');

            $dlt_type = '';
            $dlt_style = '';

            $stockCreated = DeviceStock::create([
                'unit_id' => $request->get('unit_id'),
                'make' => $request->get('make'),
                'gps_model' => $gpsModel,
                'dlt_type' => $dlt_type,
                'dlt_style' => $dlt_style,
                'who_add' => Auth::user()->name,
                'phone_number' => $request->get('phone_number'),
                'operator' => $request->get('operator'),
            ]);

            $deviceJSON = json_encode([
                'device_id' => trim($request->get('unit_id')),
                'device_name' => $stockCreated->id,
                'device_tel_no' => $request->get('phone_number'),
                'is_deleted' => 0,
                'speed_limit' => 80,
                'allow_send_data_to_dlt' => 1,
            ]);

            $ch = curl_init('http://api.wetrustgps.com:7899/api/devices/create');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $deviceJSON);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($deviceJSON))
            );

            $result = curl_exec($ch);

            return redirect('/device-stock');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        $stock = DeviceStock::find($id);

        $paymentHistory = PaymentHistory::where('imei', '=', $stock->unit_id)->get();

        return view('device-stock/show', compact('stock', 'paymentHistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return void
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $stock = DeviceStock::find($id);
        $stock->unit_id = $request->get('unit_id');
        $stock->make = $request->get('make');
        $stock->gps_model = $request->get('gps_model');
        $stock->dlt_type = $request->get('dlt_type');
        $stock->dlt_style = $request->get('dlt_style');
        $stock->phone_number = $request->get('phone_number');
        $stock->operator = $request->get('operator');
        $stock->who_add = Auth::user()->name;
        $stock->save();

        return redirect('/device-stock');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return void
     * @throws \Exception
     */
    public function destroy($id)
    {

        $stock = DeviceStock::find($id);
        $stock->delete();

        return redirect('/device-stock');
    }

    private function dltData($gps_model)
    {
        $data = [];
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
                return '0418.3/9559';
                break;
            case 'GT06E':
                return '286/2561';
            case 'VT900':
                return '296/2561';
                break;
        }
    }

    public function deviceUsed(Request $request)
    {
        //return $deviceStock = DeviceStock::where('used','=',1)->orderBy('id','desc')->paginate(100);

        if ($request->get('search')) {
            $search = $request->get('search');
            $stock = DeviceStock::where('unit_id', 'LIKE', '%' . $search . '%')
                ->where('used', '=', 1)
                ->orwhere('make', 'LIKE', '%' . $search . '%')
                ->orwhere('gps_model', 'LIKE', '%' . $search . '%')
                ->orwhere('dlt_type', 'LIKE', '%' . $search . '%')
                ->orwhere('dlt_style', 'LIKE', '%' . $search . '%')
                ->orwhere('who_add', 'LIKE', '%' . $search . '%')
                ->orwhere('phone_number', 'LIKE', '%' . $search . '%')
                ->orwhere('agent_name', 'LIKE', '%' . $search . '%')
                ->orwhere('customer_status', 'LIKE', '%' . $search . '%')
                ->orderby('id', 'desc')
                ->paginate(100);
        } else {
            $stock = DeviceStock::where('used', '=', 1)->orderBy('id', 'desc')->paginate(100);
        }

        return view('device-stock/index-used', compact('stock'));
    }

    public function deviceUnUsed(Request $request)
    {
        //return $deviceStock = DeviceStock::where('used','=',1)->orderBy('id','desc')->paginate(100);

        if ($request->get('search')) {
            $search = $request->get('search');
            $stock = DeviceStock::where('unit_id', 'LIKE', '%' . $search . '%')
                ->where('used', '=', 0)
                ->orwhere('make', 'LIKE', '%' . $search . '%')
                ->orwhere('gps_model', 'LIKE', '%' . $search . '%')
                ->orwhere('dlt_type', 'LIKE', '%' . $search . '%')
                ->orwhere('dlt_style', 'LIKE', '%' . $search . '%')
                ->orwhere('who_add', 'LIKE', '%' . $search . '%')
                ->orwhere('phone_number', 'LIKE', '%' . $search . '%')
                ->orwhere('agent_name', 'LIKE', '%' . $search . '%')
                ->orwhere('customer_status', 'LIKE', '%' . $search . '%')
                ->orderby('id', 'desc')
                ->paginate(100);
        } else {
            $stock = DeviceStock::where('used', '=', 0)->orderBy('id', 'desc')->paginate(100);
        }

        return view('device-stock/index-un-use', compact('stock'));
    }

    public function deviceUnUsedRunOnV3(Request $request)
    {

        if ($request->get('search')) {
            $search = $request->get('search');

            $stock = TempDeviceUnUse::where('imei', 'LIKE', '%' . $search . '%')
                ->orwhere('name_v3', 'LIKE', '%' . $search . '%')
            // ->where('assign_use',0)
                ->paginate(100);

        } else {
            $stock = DB::table('tmp_device_un_use')
                ->where('assign_use', 0)->paginate(100);
        }

        return view('device-stock/index-unuse-on-v3', compact('stock'));
    }

    public function updateRunOnV3($imei)
    {

        $stock = DB::table('tmp_device_un_use')->where('imei', $imei)->update(['assign_use' => 1]);

        return redirect()->back();
    }

    public function updateUnuseV3()
    {

        $stocks = DB::table('tmp_device_un_use')->get();

        foreach ($stocks as $key => $value) {
            $device = Device::where('uniqueId', $value->imei)->first();

            $stock = DB::table('tmp_device_un_use')->where('imei', $value->imei)->update(['install_date' => $device->install_date]);
        }

        return "Done";
    }

    public function stockToAgent()
    {
        $agents = Agent::all();
        return view('device-stock/set-to-agent', compact('agents'));
    }

    public function deviceForAgentView()
    {
        $agents = Agent::all();
        return view('agents/agent', compact('agents'));
    }

    public function deviceForAgent(Request $request)
    {
        $imeis = $request->get('imei');
        $extract = explode("\r\n", $imeis);
        $agent = Agent::find($request->get('agent_name'));

        foreach ($extract as $im) {
            //return $im;
            DB::table('device_stock')
                ->where('unit_id', '=', $im)
                ->update([
                    'agent_use' => $agent->id,
                    'agent_name' => $agent->agent_name,
                    'assign_agent_date' => Carbon::now()->format('Y-m-d'),
                ]);

        }

        return redirect('/agents');

    }

    public function simUpdate($id, Request $request)
    {
        $deviceStock = DeviceStock::find($id);
        $deviceStock->sim_expire_date = $request->get('sim_expire_date');
        $deviceStock->sim_last_paid = $request->get('sim_last_paid');

        $deviceStock->save();

        return redirect()->back();

    }

    public function simWillExpire()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $simWillExpire = DB::select("SELECT * FROM `device_stock` WHERE sim_expire_date BETWEEN '$startDate' AND '$endDate' ORDER BY  sim_expire_date asc");

        return view('device-stock/sim-will-expire', compact('simWillExpire'));

    }

    public function paymentList(Request $request)
    {
        if ($request->get('from_field') == 0) {
            $from_field = 'install_date';
        } else {
            $from_field = 'next_billing';
        }

        $month = $request->get('filter-month');
        $year = $request->get('filter-year');

        if ($request->get('filter-year') != '0000') {
            $paymentSoon = DB::select("SELECT count(`unit_id`) AS `imei`,`customer_name`,`customer_id`
									FROM `device_stock`
									WHERE YEAR($from_field) = '$year'
									AND MONTH($from_field) = '$month'
									GROUP BY `customer_name`
									ORDER BY `imei` DESC");
        } else {
            $paymentSoon = DB::select("SELECT count(`unit_id`) AS `imei`,`customer_name`,`customer_id`
									FROM `device_stock`
									WHERE  MONTH($from_field) = '$month'
									GROUP BY `customer_name`
									ORDER BY `imei` DESC");
        }

        return view('payments/payment-soon', compact('paymentSoon', 'from_field'));

    }
    public function paymentListAll(Request $request)
    {
        // return $request->all();
        $paymentSoon = [];

        if ($request->get('from_field') == 0) {
            $from_field = 'install_date';
        } else {
            $from_field = 'next_billing';
        }

        if ($request->get('filter-year') != '0000' || $request->get('filter-year')) {
            $thisYear = Carbon::now()->format('Y');
        } else {

            $thisYear = $request->get('filter-year');
        }

        $month = $request->get('filter-month');
        // $year = $request->get('filter-year');

        $paidYear = 'paid_' . $thisYear;

        $installThisYear = DeviceStock::whereMonth('install_date', $month)
            ->whereYear('install_date', $thisYear)
            ->count();

        $paidInThisYear = DB::table('device_stock')->where($paidYear, '=', 1)
            ->whereMonth('install_date', $month)
            ->whereYear('install_date', '!=', $thisYear)
            ->count();

        $devieCancel = DeviceStock::whereMonth($from_field, $month)
            ->where('customer_status', 0)
            ->count();

        $paymentSoon = DeviceStock::whereMonth($from_field, $month)
            ->orderBy($from_field, 'asc')
            ->where('customer_status', 1)
            ->get();

        if ($request->get('showInstallYear')) {
            $from_field = 'install_date';
            $showInstallYear = $request->showInstallYear;
            $paymentSoon = DeviceStock::whereYear($from_field, $showInstallYear)
                ->whereMonth($from_field, $month)
                ->orderBy($from_field, 'asc')
                ->where('customer_status', 1)
                ->get();

        }

        if ($request->get('listCancel') == 1) {

            $paymentSoon = DeviceStock::whereMonth('install_date', $month)
                ->where('customer_status', 0)
                ->get();

        }

        //return $paymentSoon;

        return view('payments/payment-list-all', compact('paymentSoon', 'from_field', 'installThisYear', 'paidInThisYear', 'devieCancel'));

    }

    public function paymentIMEI($imei, Request $request)
    {
        $user_id = $request->get('user_id');
        $next_paid = $request->get('next_paid');
        return view('payments/payment', compact('imei', 'user_id', 'next_paid'));
    }

    public function paymentIMEIstore($imei, Request $request)
    {
        // return $request->all();

        // $validate = $request->validate([
        //     //'paid_slip' => 'required',
        //     'paid_date' => 'required',
        // ]);

        if ($request->file('paid_slip')) {
            $file = $request->file('paid_slip');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->move('uploads/paid-slip', $file_name);

        } else {
            $file_name = '';
            $file_path = '';
        }
        $paid = PaymentHistory::create([
            'imei' => $imei,
            'user_id' => $request->get('user_id'),
            'paid_date' => Carbon::parse($request->get('paid_date'))->format('Y-m-d'),
            'paid_channel' => $request->get('paid_channel'),
            'bank' => $request->get('bank'),
            'paid_for_year' => $request->get('paid_for_year'),
            'next_paid' => $request->get('next_paid'),
            'receipt_no' => $request->get('receipt_no'),
            'paid_slip' => $file_path,
            'payment_type' => $request->get('payment_type'),
            'paid_total' => $request->get('paid_total'),
            'note' => $request->get('note'),
            'who_operate' => $request->get('who_operate'),
        ]);

        $next_billingYear = $request->get('paid_for_year') + 1;
        $prefix = 'paid_';
        $paidForYear = $request->get('paid_for_year');
        $paidForYearField = $prefix . $paidForYear;
        $deviceStok = DeviceStock::where('unit_id', '=', $imei)->first();
        $deviceInstallDate = Carbon::parse($deviceStok->next_billing)->format('m-d');
        $deviceInstallDate = $next_billingYear . '-' . $deviceInstallDate;
        $deviceStok->next_billing = $deviceInstallDate;
        $deviceStok->$paidForYearField = 1;
        $deviceStok->save();

        return redirect('/payment-list-all');
    }

    public function paidList(Request $request)
    {
        if ($request->get('search')) {
            $search = $request->get('search');
            $paidList = PaymentHistory::where('imei', 'LIKE', '%' . $search . '%')
                ->orwhere('receipt_no', 'LIKE', '%' . $search . '%')
                ->orwhere('next_paid', 'LIKE', '%' . $search . '%')
                ->orwhere('paid_for_year', 'LIKE', '%' . $search . '%')
                ->orwhere('paid_channel', 'LIKE', '%' . $search . '%')
                ->orwhere('paid_date', 'LIKE', '%' . $search . '%')
                ->orderby('id', 'desc')
                ->paginate(100);
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $paidList = PaymentHistory::paginate(100);

        }

        return view('payments/paid-list', compact('paidList'));
    }

    public function unkonwOwner()
    {
        $data = DB::select("SELECT * FROM device_stock WHERE `agent_use` IS NOT NULL AND `customer_id` IS NULL");

        return view('device-stock/unknow-owner', compact('data'));
    }

    public function updateNextBilling()
    {
        $paymentHistory = DB::select("SELECT * FROM payment_history WHERE `migrated` = 0 AND payment_type = 'Yearly' ");
        //$paymentHistory = DB::select("SELECT * FROM payment_history WHERE `paid_for_year` = '2019' ");
        $now = Carbon::now()->format('Y');
        $prefix = 'paid_';
        foreach ($paymentHistory as $key => $value) {

            $deviceStock = DeviceStock::where('unit_id', $value->imei)->first();

            try {
                $installYear = Carbon::parse($deviceStock->install_date)->format('Y');
                $installMonth = Carbon::parse($deviceStock->install_date)->format('m');
                $installDate = Carbon::parse($deviceStock->install_date)->format('d');

                $diffYears = $now - $installYear;
                $nextYear = $value->paid_for_year + 1;

                $nextBilling = Carbon::create($nextYear, $installMonth, $installDate);
                $paidYear = $prefix . $value->paid_for_year;
                $deviceStock->next_billing = $nextBilling;
                $deviceStock->last_paid = $value->paid_date;
                $deviceStock->payment_condition = $value->payment_type;
                $deviceStock->last_paid_for_year = $value->paid_for_year;
                $deviceStock->customer_name = $value->customer_name;
                //$deviceStock->paid_2019 = 1;
                $deviceStock->save();

                $deviceStock = DeviceStock::where('unit_id', $value->imei)
                    ->update([
                        $prefix . $value->paid_for_year => 1,
                    ]);

                DB::table('payment_history')->where('id', $value->id)
                    ->update(['migrated' => 1]);

            } catch (\Throwable $th) {
                echo $value->imei . "<br/>";
            }

        }

        return "Done";
    }

    public function updatePaidYear($year)
    {
        //$paymentHistory = DB::select("SELECT * FROM payment_history WHERE `migrated` = 0 AND payment_type = 'Yearly' ");
        $paymentHistory = DB::select("SELECT * FROM payment_history WHERE `paid_for_year` = '$year' AND payment_type = 'Yearly' ");
        $now = Carbon::now()->format('Y');
        $prefix = 'paid_';
        foreach ($paymentHistory as $key => $value) {

            $deviceStock = DeviceStock::where('unit_id', $value->imei)->first();

            try {
                // $installYear = Carbon::parse($deviceStock->install_date)->format('Y');
                // $installMonth = Carbon::parse($deviceStock->install_date)->format('m');
                // $installDate = Carbon::parse($deviceStock->install_date)->format('d');

                // $diffYears = $now - $installYear;
                $nextYear = $value->paid_for_year + 1;

                // $nextBilling = Carbon::create($nextYear,$installMonth,$installDate);
                // $paidYear =  $prefix.$value->paid_for_year;
                // $deviceStock->next_billing = $nextBilling;
                // $deviceStock->last_paid = $value->paid_date;
                // $deviceStock->payment_condition = $value->payment_type;
                // $deviceStock->last_paid_for_year = $value->paid_for_year;
                // $deviceStock->paid_2019 = 1;
                $deviceStock->save();

                $deviceStock = DeviceStock::where('unit_id', $value->imei)
                    ->update([
                        $prefix . $year => 1,
                    ]);

                DB::table('payment_history')->where('id', $value->id)
                    ->update(['migrated' => 1]);

            } catch (\Throwable $th) {
                echo $value->imei . "<br/>";
            }

        }

        return "Done";
    }

    public function updatePaidInstall($year)
    {

        $prefix = 'paid_';
        DeviceStock::whereYear('install_date', $year)
            ->update([
                $prefix . $year => 1,
            ]);

        return "Done";
    }

    public function updatePivotImei()
    {

        $data = DB::table('device_gps')
            ->whereNull('imei')
            ->get();

        foreach ($data as $key => $value) {

            $deviceStock = DeviceStock::find($value->gps_stock_id);

            if ($deviceStock) {
                $update = DB::table('device_gps')->where('gps_stock_id', $value->gps_stock_id)
                    ->update(['imei' => $deviceStock->unit_id]);
            }

        }

        return "Done";
    }

    public function deviceCancel(Request $request)
    {
        $device = DeviceStock::where('unit_id', $request->get('imei'))->first();

        $device->customer_status = 0;
        $device->customer_note = $request->get('note');
        $device->save();

        $stock = DB::table('tmp_device_un_use')->where('imei', $request->get('imei'))->update(['assign_use' => 1]);

        return redirect()->back();
    }

    public function paymentHistory(Request $request)
    {

        // if ($request->get('filter-date')) {
        //     $date = Carbon::parse($request->get('filter-date'))->format('Y-m-d');
        //     $payments = DB::table('payment_history')
        //         ->where('paid_date', $date)
        //         ->paginate(100);
        // } elseif ($request->get('filter-month') && $request->get('filter-month') != '00') {
        //     $payments = DB::table('payment_history')
        //         ->whereMonth('paid_date', $request->get('filter-month'))
        //         ->paginate(100);
        // } else {
        //     $payments = DB::table('payment_history')

        //         ->paginate(100);
        // }

         $payments = DB::table('invoices')->paginate(25);

        return view('payments/payment-history', compact('payments'));
    }

    public function paymentListOld(Request $request)
    {

        if ($request->get('from_field') == 0) {
            $from_field = 'install_date';
        } else {
            $from_field = 'next_billing';
        }

        $month = $request->get('filter-month');
        $year = $request->get('filter-year');

        if ($request->get('filter-year') != '0000') {
            // return    $paymentSoon = DB::select("SELECT count(`unit_id`) AS `imei`,`customer_name`,`customer_id`
            //         FROM `device_stock`
            //         WHERE YEAR($from_field) = '$year'
            //         AND MONTH($from_field) = '$month'
            //         GROUP BY `customer_name`
            //         ORDER BY `imei` DESC");
            $paymentSoon = DeviceStock::whereMonth($from_field, $request->get('filter-month'))->get();

            $deviceTBLRe = Device::whereMonth($from_field, $request->get('filter-month'))->get();
        } else {
            // $paymentSoon = DB::select("SELECT count(`unit_id`) AS `imei`,`customer_name`,`customer_id`
            //     FROM `device_stock`
            //     WHERE  MONTH($from_field) = '$month'
            //     GROUP BY `customer_name`
            //     ORDER BY `imei` DESC");
            $paymentSoon = DeviceStock::whereMonth($from_field, $request->get('filter-month'))->get();

            $deviceTBLRe = Device::whereMonth($from_field, $request->get('filter-month'))->get();
        }

        $deviceTBL = [];
        foreach ($deviceTBLRe as $value) {
            $deviceTBL[$value->id] = $value->uniqueId;

        }

        $deviceStockTBL = [];
        foreach ($paymentSoon as $value) {
            $deviceStockTBL[$value->id] = $value->unit_id;
        }

        $unKeyDevice = array_diff($deviceTBL, $deviceStockTBL);

        $implodeUnkey = implode(",", $unKeyDevice);
        $unKeyDeviceData = [];
        try {
            $unKeyDeviceData = DB::select("SELECT * FROM `device` WHERE `uniqueId` IN ($implodeUnkey)");
        } catch (\Illuminate\Database\QueryException $ex) {

        }

        //return $unKeyDeviceData;

        //return view('payments/payment-soon',compact('paymentSoon','from_field','unKeyDevice','unKeyDeviceData'));
        return view('payments/payment-soon-old', compact('paymentSoon', 'from_field', 'unKeyDeviceData', 'unKeyDevice'));

    }
}
