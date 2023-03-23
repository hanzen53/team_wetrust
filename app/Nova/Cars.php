<?php

namespace App\Nova;

use App\CarMaker;
use App\DLTCarType;
use App\DLTCustomer;
use App\DLTProvince;
use Koss\LaravelNovaSelect2\Select2;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;


class Cars extends Resource
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
    public static $model = 'App\DLTCar';
    
    /**
    * The single value that should be used to represent the resource when being displayed.
    *
    * @var string
    */
    public static $title = 'register_name';
    
    /**
    * The columns that should be searched.
    *
    * @var array
    */
    public static $search = [
        'id',
        'register_name',
        'register_chassi',
        'register_type',
    ];
    
    /**
    * Get the fields displayed by the resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function fields(Request $request)
    {
        $provinces = DLTProvince::all()->pluck('province_name','province_id');
        $carTypes = DLTCarType::all()->pluck('detail','code');
        $carMake = CarMaker::all()->pluck('maker','maker');
        $customers = DLTCustomer::all()->pluck('name','id');
        
        
        return [
            ID::make()->sortable(),
            
            
            Text::make('ทะเบียน','register_name',function (){
                $firstChar = mb_substr($this->register_name,0,1);
                if($firstChar == 0){
                    $char = mb_substr($this->register_name,1,2);
                    $number = mb_substr($this->register_name,-4);
                    $register_number = $char.'-'.$number;
                    
                }else{
                    $char = mb_substr($this->register_name,0,2);
                    $number = mb_substr($this->register_name,-4);
                    $register_number = $char.'-'.$number;
                }
                
                return $register_number;
            })
            ->creationRules('required')
            ->updateRules('required')
            ->help(
                'ห้ามมีขีดถ้าน้อยกว่า 7 ตัวให้เติม 0 ข้างหน้าให้ครบ  นข-4363 -> 0นข4363'
                )
                ->sortable(),
                
                Select2::make('จังหวัด', 'register_province')
                //->hideFromIndex()
                ->creationRules('required')
                ->updateRules('required')
                ->options($provinces)
                /**
                * Documentation
                * https://select2.org/configuration/options-api
                */
                ->configuration([
                    'placeholder'             => __('เลือกจังหวัด'),
                    'allowClear'              => true,
                    'minimumResultsForSearch' => 1
                    ]),
                    
                    Text::make('ชื่อประกอบการ','business_name')->sortable(),
                    Text::make('หมายเลขตัวถัง','register_chassi')->sortable(),
                    Text::make('แบบ','register_type')->sortable(),
                    
                    Date::make('วันที่จดทะเบียน','register_date')->hideFromIndex(),

                    Text::make('มาตรฐาน','register_standard')->hideFromIndex(),
       
                    Select2::make('ประเภท', 'register_type')
                    ->hideFromIndex()
                    ->creationRules('required')
                    ->updateRules('required')
                    ->options($carTypes)
                    /**
                    * Documentation
                    * https://select2.org/configuration/options-api
                    */
                    ->configuration([
                        'placeholder'             => __('เลือกประเภทรถ'),
                        'allowClear'              => true,
                        'minimumResultsForSearch' => 1
                        ]),
                        
                        Select2::make('ยี่ห้อรถ', 'register_make')
                        ->hideFromIndex()
                        ->creationRules('required')
                        ->updateRules('required')
                        ->options($carMake)
                        /**
                        * Documentation
                        * https://select2.org/configuration/options-api
                        */
                        ->configuration([
                            'placeholder'             => __('เลือกยี่ห้อรถ'),
                            'allowClear'              => true,
                            'minimumResultsForSearch' => 1
                            ]),
   
                            new Panel('IMEI ที่ผูก', $this->imei()),
                            
                            new Panel('เจ้าของรถ', $this->customer()),
                            
                        ];
                    }
                    
                    protected function imei(){
                        
                        return [
                            //BelongsToMany::make('Device Stock','gps_stock')
                            BelongsToMany::make('IMEI ที่ผูก','gps_stock','App\Nova\DeviceStock')
                        ];
                    }
                    protected function customer(){
                        
                        return [
                            
                            HasOne::make('เจ้าของรถ','oneCustomer','App\Nova\Customers')
                            
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
                        return [];
                    }
                    
                    /**
                    * Get the filters available for the resource.
                    *
                    * @param  \Illuminate\Http\Request  $request
                    * @return array
                    */
                    public function filters(Request $request)
                    {
                        return [];
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
                            new DownloadExcel,
                        ];
                    }
                    
                    /**
                    * Get the displayble label of the resource.
                    *
                    * @return string
                    */
                    public static function label()
                    {
                        return __('ข้อมูลรถ DLT');
                    }
                    
                    /**
                    * Get the displayble singular label of the resource.
                    *
                    * @return string
                    */
                    public static function singularLabel()
                    {
                        return __('ข้อมูลรถ DLT');
                    }
                }
                