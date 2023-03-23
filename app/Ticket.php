<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;
use Laravel\Scout\Searchable;


class Ticket extends Model
{
    use  Actionable;
	protected static $logName = 'Ticket';

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tickets';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

	public function customer()
	{
		return $this->belongsTo('App\DLTCustomer');
    }

	public function callCenter()
	{
		return $this->belongsTo('App\User','call_center_id');
	}

}
