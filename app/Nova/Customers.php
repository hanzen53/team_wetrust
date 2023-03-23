<?php

namespace App\Nova;

use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Pdewit\ExternalUrl\ExternalUrl;

class Customers extends Resource
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
    public static $model = 'App\DLTCustomer';

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
        'id',
        'name',
        'business_name',
        'tel',
        'username',
        'email',
        'citizen_id'
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
            Text::make('ID Card/TAX ID','citizen_id')->sortable(),
            Text::make('ชื่อ','name')
                ->creationRules('required')
                ->updateRules('required')
                ->sortable(),
            Text::make('ชื่อประกอบการ','business_name')->sortable(),
            Text::make('Tel','tel')
                ->creationRules('required')
                ->updateRules('required')
                ->sortable(),
            Date::make('วันเกิด','birthday')->format('DD/MM/YYYY')->hideFromIndex(),
            Text::make('Email','email')->hideFromIndex(),
            Text::make('Note','note')->hideFromIndex(),

            Image::make('บัตรประชาชน','id_card')
                ->disk('public')
                ->path('customers')
                ->storeAs(function (Request $request){
                    return $request->id_card->getClientOriginalName();
                }),
            new Panel('ที่อยู่ลูกค้า', $this->addressFields()),
            new Panel('ข้อมูล Login', $this->loginInfo()),

            new Panel('รถทั้งหมด', $this->cars()),

            new Panel('Ticket แจ้งปัญหา', $this->tickets()),

            new Panel('Note', $this->notes()),


        ];
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function addressFields()
    {
        return [
            Place::make('เลขที่', 'address_one')->hideFromIndex(),
            Textarea::make('ที่อยู่','address_auto')->alwaysShow()->hideFromIndex(),
        ];
    }

    protected function loginInfo(){

        return [
//            Text::make('User Login URL','user_login_id',function(){
//            return "http://center.wetrustgps.com/remote-login/".$this->user_login_id;
//              })->hideFromIndex(),
            Text::make('Username','username')->hideFromIndex(),
            Text::make('Password','password')->hideFromIndex(),

            ExternalUrl::make('User Login URL', function () {
                return "http://center.wetrustgps.com/remote-login/".$this->user_login_id;
            })->linkText($this->username),
        ];
    }

    protected function cars(){

        return [
            HasMany::make('ข้อมูลรถ', 'dltCars', 'App\Nova\Cars')
        ];
    }

    public function tickets(){
        return [
            HasMany::make('Ticket แจ้งปัญหา','tickets','App\Nova\Tickets')
        ];
    }

    public function notes(){
        return [
            HasMany::make('Note','notes','App\Nova\CustomerNote')
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
        return __('ข้อมูลลูกค้า');
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('ข้อมูลลูกค้า');
    }
}
