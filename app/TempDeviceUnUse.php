<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempDeviceUnUse extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tmp_device_un_use';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
