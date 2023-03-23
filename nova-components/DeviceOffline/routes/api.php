<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

 Route::get('/', function (Request $request) {
     $url = 'http://api.wetrustgps.com:7899/api/devices/offline';
     try{
         $dataJosn = file_get_contents($url);
         return $data = json_decode($dataJosn,true);
     }catch (Error $e){
        Log::debug($e);
     }

 });
