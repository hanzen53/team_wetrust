<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketAttribute extends Model
{
	protected static $logName = 'TicketAttribute';

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticket_attributes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
