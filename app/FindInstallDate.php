<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FindInstallDate extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'find_install_date_temp';
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $guarded = ['id'];
}
