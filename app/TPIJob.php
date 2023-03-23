<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TPIJob extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tpi_jobs';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
}
