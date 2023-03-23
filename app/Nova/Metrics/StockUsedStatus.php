<?php

namespace App\Nova\Metrics;


use App\DeviceStock;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class StockUsedStatus extends Partition
{
    public $name = 'Stock ใช้งาน / ยังไม่ใช้งาน';
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, DeviceStock::class, 'used')
            ->label(function ($value){
                switch ($value) {
                    case 0:
                        return 'ยังไม่ใช้งาน';
                    default:
                        return 'ใช้งานแล้ว';
                }
            })
            ->colors([]);
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
        return 'stock-used-status';
    }
}
