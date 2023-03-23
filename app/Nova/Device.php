<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Device extends Resource
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
    public static $model = 'App\Device';
    
    /**
    * The single value that should be used to represent the resource when being displayed.
    *
    * @var string
    */
    public static $title = 'name';
    
    /**
    * The columns that should be searched.
    *
    * @var array
    */
    public static $search = [
        'id','name','uniqueId','sim_phone_no',
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
            Text::make('IMEI','uniqueId')
            ->creationRules('required')
            ->updateRules('required')
            ->sortable(),
            Text::make('ทะเบียน','name')
            ->sortable(),
            Text::make('Phone no','sim_phone_no')
            ->sortable(),
            
            Date::make('วันที่ติดตั้ง','install_date')
            ->sortable(),
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
        return [];
    }
    
    /**
    * Get the displayble label of the resource.
    *
    * @return string
    */
    public static function label()
    {
        return __('ข้อมูลรถ V3');
    }
    
    /**
    * Get the displayble singular label of the resource.
    *
    * @return string
    */
    public static function singularLabel()
    {
        return __('ข้อมูลรถ V3');
    }
}
