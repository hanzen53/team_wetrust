<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Nova\Actions\Actionable;
use Laravel\Scout\Searchable;


class DLTCustomer extends Model
{
    use  Actionable;

	protected static $logName = 'DLTCustomer';

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dlt_customer';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'birthday' => 'date'
    ];


    /**
     * Relationship
     */

    public function dltCars()
    {
        return $this->hasMany(DLTCar::class,'owner_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'user_id');
    }

    public function notes()
    {
        return $this->hasMany(DLTCustomerNote::class,'customer_id');
    }

}
