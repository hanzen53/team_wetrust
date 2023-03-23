<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CarMaker extends Model
{

	protected static $logName = 'CarMaker';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'car_maker';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}
