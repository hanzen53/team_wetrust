<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class FileImageCustomer extends Model
{

	protected static $logName = 'FileImageCustomer';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'files_image_customers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
}
