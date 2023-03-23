<?php

namespace App\Nova\Metrics;

use App\DLTCustomer;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend;

class CustomerCountTrend extends Trend
{
    public $name = 'กราฟลูกค้า';
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByMonths($request, DLTCustomer::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            3 => '3 Months',
            6 => '6 Months',
            9 => '9 Months',
            12 => '12 Months',
            24 => '24 Months',
            36 => '36 Months',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'customer-count-trend';
    }
}
