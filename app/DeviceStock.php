<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;
use Laravel\Scout\Searchable;


class DeviceStock extends Model
{
    
    use  Actionable;
    
    protected $casts = [
        'install_date' => 'date',
        'sim_expire_date' => 'date',
        'sim_last_paid' => 'date',
        'next_billing' => 'date',
        'last_paid' => 'date',
    ];
    
	protected static $logName = 'DeviceStock';
    
	/**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'device_stock';
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $guarded = ['id'];
    
    public function dlt_car()
    {
        return $this->belongsToMany('App\DLTCar','device_gps','gps_stock_id','dlt_car_id');
    }
    
    /**
    * Get the phone record associated with the user.
    */
    public function simcardNo()
    {
        return $this->belongsTo('App\SimCard','simcard_id');
    }
}
