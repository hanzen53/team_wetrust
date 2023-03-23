<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Nova\Actions\Actionable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable,Actionable;
	protected static $logName = 'User';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	/**
	 * Create relation for Devices model
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function devices()
	{
		return $this->belongsToMany(Device::class, 'device_user')->withTimestamps();
	}

	public function tickets()
	{
		//return $this->belongsTo('App\Ticket');
		return $this->hasMany('App\Ticket');

	}
}
