<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;
use Laravel\Scout\Searchable;


class Device extends Model
{
    protected $casts = [
        'install_date' => 'date'
    ];

    use  Actionable;
	protected static $logName = 'Device';

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'device';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

	/**
	 * Create relation for User model
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users(){
		return $this->belongsToMany(User::class,'device_user');
	}
}
