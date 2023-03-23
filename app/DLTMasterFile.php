<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DLTMasterFile extends Model
{
   
	protected static $logName = 'DLTCar';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dlt_master_file';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
}
