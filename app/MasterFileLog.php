<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;
use Laravel\Scout\Searchable;


class MasterFileLog extends Model
{
    use  Actionable;

	protected static $logName = 'masterfile_logs';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'masterfile_logs';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
}
