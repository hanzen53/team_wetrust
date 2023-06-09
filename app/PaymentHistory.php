<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
	//
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'payment_history';
	
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $guarded = ['id'];
}