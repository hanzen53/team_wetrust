<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class FileImage extends Model
{

	protected static $logName = 'FileImage';

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files_and_images';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
