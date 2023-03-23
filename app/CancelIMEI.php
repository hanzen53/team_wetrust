<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelIMEI extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'device_cancel';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
}
