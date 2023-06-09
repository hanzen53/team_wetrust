<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Unkey extends Model
{

	protected static $logName = 'Unkey';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'customer_unkey';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}
