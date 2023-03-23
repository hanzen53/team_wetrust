<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use App\Nova\Filters\SIMExpire;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class SimCard extends Resource
{

    public static $displayInNavigation = true;

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
    public static $model = 'App\SimCard';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'phone_no';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','phone_no','operator','expire_date',
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
            Text::make('เบอร์โทร','phone_no')->sortable(),
            Select::make('เครือข่าย','operator')->options([
                'TRUE' => 'TRUE',
                'DTAC' => 'DTAC',
                'AIS' => 'AIS',
            ]),
            Date::make('วันหมดอายุ','expire_date')->sortable(),
            Number::make('คงเหลือ','balance')->sortable(),
            Date::make('วันที่ตรวจล่าลุด','last_check')->sortable(),
            BelongsTo::make('User')->searchable()->withMeta([
                'belongsToId' => $this->user_id ?? auth()->user()->id
            ]),
            BelongsTo::make('Device Stock','gps_stock')->searchable()->nullable(),
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
        return [
            new SIMExpire,
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
        return [];
    }

        /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('SIM Card');
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('SIM Card');
    }
}
