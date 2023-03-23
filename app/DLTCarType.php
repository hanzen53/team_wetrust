<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DLTCarType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dlt_car_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
