<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Trix;


class Tickets extends Resource
{
    /**
     * Group
     * @var string
     */
    public static $group = 'Admin';

    /**
     * Hide from sidebar
     * @var bool
     */
    public static $displayInNavigation = false;


    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = \App\Ticket::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var  string
     */
    public static $title = 'subject';

    /**
     * The columns that should be searched.
     *
     * @var  array
     */
    public static $search = [
        'id', 'subject',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return  string
     */
    public static function label()
    {
        return __('Tickets');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return  string
     */
    public static function singularLabel()
    {
        return __('Tickets');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function fields(Request $request)
    {
        return [

            Text::make( __('Subject'),  'subject')
                ->sortable()
            ,
            Trix::make( __('Content'),  'content')
                ->hideFromIndex()
                ->sortable()
            ,

            Text::make( __('ทะเบียน'),  'car_license')
                ->sortable()
            ,


            Select::make('ความสำคัญ','priority')->options([
                'สูง' => 'สูง',
                'ปานกลาง' => 'ปานกลาง',
                'ต่ำ' => 'ต่ำ',
            ]),

            Boolean::make( __('สถานะ'),  'active')
                ->sortable()
            ,
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
