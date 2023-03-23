<?php

namespace App\Http\Controllers;

use App\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeSheetController extends Controller
{
    public function __construct()
    {

    }
    
    public function index()
    {
        $workingTime = TimeSheet::where('user_id','=',Auth::user()->id)->get();
        
        return view('timesheet/dashboard',compact('workingTime'));
    }
    
    public function create()
    {
        return view('timesheet/create');
    }
}
