<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TicketImage extends Model
{

	protected static $logName = 'TicketImage';

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticket_images';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
