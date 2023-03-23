<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function __construct()
    {

    }
    
    public function uploadForm()
    {
        return view('technician/upload');
    }
}
