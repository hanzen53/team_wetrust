<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Password;

class TeamUser extends Resource
{
    /**
    * Group
    * @var string
    */
    public static $group = 'Admin';
    
    /**
    * Get the displayble label of the resource.
    *
    * @return string
    */
    public static function label()
    {
        return __('พนักงาน');
    }
    
    /**
    * Get the displayble singular label of the resource.
    *
    * @return string
    */
    public static function singularLabel()
    {
        return __('พนักงาน');
    }
    
    /**
    * The model the resource corresponds to.
    *
    * @var string
    */
    public static $model = 'App\User';
    
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
        'id','username','name','email','line','tel',
    ];
    
    /**
    * Build an "index" query for the given resource.
    *
    * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
    * @param  \Illuminate\Database\Eloquent\Builder  $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('user_type','employee');
    }
    
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
            Text::make('ชื่อ','name')->sortable(),
            Text::make('Email','email')->sortable(),
            Text::make('Tel','tel')->sortable(),
            Text::make('Line ID','line')->sortable(),
            Password::make('Password','password')->hideFromIndex(),
            Avatar::make('ภาพโปรไฟล์','avatar')
            ->disk('public')
                ->path('team-users')
                ->storeAs(function (Request $request){
                    return $request->avatar->getClientOriginalName();
                })->sortable(),
            Boolean::make('ยังคงเป็นพนักงาน','status')->sortable(),
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
}
