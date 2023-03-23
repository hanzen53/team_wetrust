<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Filters\DeviceStockUsed;
use App\Nova\Metrics\StockUsedStatus;
use App\Nova\Filters\DeviceStockInUse;
use App\Nova\Actions\AssignStockTOAgent;
use App\Nova\Filters\GPSSetupDateFilter;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Actions\CreateOnRealTimeServer;

class DeviceStock extends Resource
{
    /**
    * Group
    * @var string
    */
    public static $group = 'Admin';
    
    
    /**
    * The model the resource corresponds to.
    *
    * @var string
    */
    public static $model = 'App\DeviceStock';
    
    /**
    * The single value that should be used to represent the resource when being displayed.
    *
    * @var string
    */
    public static $title = 'unit_id';
    
    /**
    * The columns that should be searched.
    *
    * @var array
    */
    public static $search = [
        'id',
        'unit_id',
        'phone_number',
        'gps_model',
        'dlt_type'
    ];
    
    /**
    * Get the fields displayed by the resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function fields(Request $request)
    {
        
        return [
            ID::make()->sortable(),
            
            Text::make('IMEI','unit_id')
            ->creationRules('required', 'string', 'unique:device_stock')
            //->updateRules('required', 'string', 'unique:device_stock')
            //                ->updateRules('unique:device_stock,{{resourceId}}')
            ->sortable(),
            
            // Select::make('ค่าย','operator')->options([
            //     'True' => 'True',
            //     'AIS' => 'AIS',
            //     'DTAC' => 'DTAC',
            //     'myByCAT' => 'myByCAT',
            //     ]),
                
                Text::make('ค่าย','operator')->exceptOnForms()->sortable(),
                Text::make('เบอร์','phone_number')->exceptOnForms()->sortable(),
                Date::make('หมดอายุ','sim_expire_date')->exceptOnForms()->sortable(),
            //     ->sortable(),
                
            //     Date::make('วันหมดอายุ','sim_expire_date')->sortable(),
            //     Date::make('เติมเงินเมื่อ','sim_last_paid')->sortable(),
                
                
                Select::make('รุ่น','gps_model')->options([
                    'AW-GPS-3G' => 'AW-GPS-3G',
                    'ET800D-3G' => 'ET800D-3G',
                    'ET800M' => 'ET800M',
                    'TS107' => 'TS107',
                    'TS1073G' => 'TS1073G',
                    'T-333' => 'T-333',
                    'GT06E' => 'GT06E',
                    'VT900' => 'VT900',
                    'TK115' => 'TK115',
                    'TK116' => 'TK116',
                    'LK210' => 'LK210',
                    'GV20' => 'GV20',
                    'ST901' => 'ST901',
                    'TM7' => 'TM7',
                    'GPS103' => 'GPS103',
                    ])
                    ->creationRules('required')
                    ->updateRules('required'),

                    Date::make('SETUP','install_date')->sortable(),
                    Date::make('รอบบิลถัดไป','next_billing')->sortable(),
                    Date::make('ชำระล่าสุด','last_paid')->sortable(),
                    
                    Text::make('ทะเบียน','installed_on_car',function (){
                        
                        $firstChar = mb_substr($this->installed_on_car,0,1);
                        if($firstChar == 0){
                            $char = mb_substr($this->installed_on_car,1,2);
                            $number = mb_substr($this->installed_on_car,-4);
                            $register_number = $char.'-'.$number;
                            
                        }else{
                            $char = mb_substr($this->installed_on_car,0,2);
                            $number = mb_substr($this->installed_on_car,-4);
                            $register_number = $char.'-'.$number;
                        }
                        
                        return $register_number;
                    })->sortable(),
                    
                    Boolean::make('Status','customer_status')
                    ->help(
                        'ลูกค้ายังใช้งาน / ยกเลิก'
                        )
                        ->sortable(),
   
                        BelongsTo::make('Sim Card','simcardNo')->searchable()->nullable()
             
                    ];
                }
                
                /**
                * Get the cards available for the request.
                *
                * @param  \Illuminate\Http\Request  $request
                * @return array
                */
                public function cards(Request $request)
                {
                    return [
                        (new StockUsedStatus)->width('2/3')
                    ];
                }
                
                /**
                * Get the filters available for the resource.
                *
                * @param  \Illuminate\Http\Request  $request
                * @return array
                */
                public function filters(Request $request)
                {
                    return [
                        new DeviceStockUsed,
                        new DeviceStockInUse,
                        new GPSSetupDateFilter
                    ];
                }
                
                /**
                * Get the lenses available for the resource.
                *
                * @param  \Illuminate\Http\Request  $request
                * @return array
                */
                public function lenses(Request $request)
                {
                    return [];
                }
                
                /**
                * Get the actions available for the resource.
                *
                * @param  \Illuminate\Http\Request  $request
                * @return array
                */
                public function actions(Request $request)
                {
                    return [
                        new  AssignStockToAgent,
                        new  CreateOnRealTimeServer,
                    ];
                }
                
                /**
                * Get the displayble label of the resource.
                *
                * @return string
                */
                public static function label()
                {
                    return __('GPS Stocks');
                }
                
                /**
                * Get the displayble singular label of the resource.
                *
                * @return string
                */
                public static function singularLabel()
                {
                    return __('GPS Stocks');
                }
            }
            