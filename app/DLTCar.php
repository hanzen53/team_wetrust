<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;
use Laravel\Scout\Searchable;


class DLTCar extends Model
{

    use  Actionable;

    protected $casts = [
        'register_date' => 'date'
    ];

	protected static $logName = 'DLTCar';

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dlt_cars';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];



    /**
     * Relationship
     */
    public function gps_stock()
    {
        return $this->belongsToMany('App\DeviceStock','device_gps','dlt_car_id','gps_stock_id');
    }


    public function dltCustomers()
    {
       return $this->belongsTo(DLTCustomer::class);
    }

    public function oneCustomer(){
        return $this->hasOne(DLTCustomer::class,'id','owner_id');
    }




}
