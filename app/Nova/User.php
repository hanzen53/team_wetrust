<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Scout\Searchable;
use App\Nova\Actions\UserDevice;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Actions\Actionable;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class User extends Resource
{
    /**
    * Get the displayble label of the resource.
    *
    * @return string
    */
    public static function label()
    {
        return __('User ลูกค้า');
    }
    
    /**
    * Get the displayble singular label of the resource.
    *
    * @return string
    */
    public static function singularLabel()
    {
        return __('User ลูกค้า');
    }
    
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
    public static $model = 'App\\User';
    
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
        'id', 'name', 'email',
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
            
            //            Gravatar::make(),
            
            Text::make('Name')
            ->sortable()
            ->rules('required', 'max:255'),
            
            Text::make('Email')
            ->sortable()
            ->rules('required', 'email', 'max:254')
            ->creationRules('unique:users,email')
            ->updateRules('unique:users,email,{{resourceId}}'),
            
            Text::make('Tel')
            ->sortable()
            ->rules('required', 'max:20')
            ->creationRules('required', 'string', 'min:10')
            ->updateRules('nullable', 'string', 'min:10'),
            
            Password::make('Password')
            ->onlyOnForms()
            ->creationRules('required', 'string', 'min:4')
            ->updateRules('nullable', 'string', 'min:4'),

            HasMany::make('Device','devices')
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
            //new DownloadExcel,
            new UserDevice
        ];
    }
}
