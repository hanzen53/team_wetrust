<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TicketNote extends Model
{
	protected static $logName = 'TicketNote';

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticket_notes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
