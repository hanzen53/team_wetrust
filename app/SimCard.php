<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    protected $casts = [
        'expire_date' => 'date',
        'last_check' => 'date',
    ];
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'simcard';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo(User::class,'add_via_user_id');
    }

    public function gps_stock()
    {
        return $this->belongsTo(DeviceStock::class,'stock_id');
    }
}
