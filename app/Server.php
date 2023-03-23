<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Server extends Model
{

	protected static $logName = 'Server';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'servers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
}
