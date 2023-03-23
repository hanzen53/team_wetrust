<?php

namespace App\Http\Controllers;

use App\TicketAttribute;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    protected $teams;
    
    public function __construct()
    {

    }
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     

}
