<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

class MongoDriver extends Eloquent
{
	protected $connection = 'mongodb';

}
