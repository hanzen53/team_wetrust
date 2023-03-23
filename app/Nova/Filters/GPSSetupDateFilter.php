<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class GPSSetupDateFilter extends Filter
{
    public $name = 'เดือนที่ติดตั้ง';
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->whereMonth('install_date',$value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'JAN'=>'01',
            'FEB'=>'02',
            'MAR'=>'03',
            'APR'=>'04',
            'MAY'=>'05',
            'JUN'=>'06',
            'JUL'=>'07',
            'AUG'=>'08',
            'SEP'=>'09',
            'OCT'=>'10',
            'NOV'=>'11',
            'DEC'=>'12',
        ];
    }
}
