<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;
use Laravel\Scout\Searchable;


class DLTCustomerNote extends Model
{
    use  Actionable;

	protected static $logName = 'DLTCar';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dlt_customer_note';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

    public function dltCustomers()
    {
        return $this->belongsTo(DLTCustomer::class);
    }
}
