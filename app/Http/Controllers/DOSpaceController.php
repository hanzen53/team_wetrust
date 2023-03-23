<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DOSpaceController extends Controller
{
	/**
	 * @param Request $request
	 * @return string
	 */
	public function uploadFile(Request $request)
	{
		//return "Uploaded";

		$ext = $request->file('upload_file')->extension();
		$fileName = $request->file('upload_file')->getClientOriginalName();
		$path = Storage::disk('do_space')->putFileAs('uploads',$request->file('upload_file'),$fileName.'_'.time().'.'.$ext,'public');

		return "Uploaded";
    }
}
