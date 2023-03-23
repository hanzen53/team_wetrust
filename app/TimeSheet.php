<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
	protected static $logName = 'TimeSheet';

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timesheet';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
