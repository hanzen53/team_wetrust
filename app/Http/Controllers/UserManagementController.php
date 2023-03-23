<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function profile()
	{
		$user = Auth::user();

		return view('users/profile',compact('user'));
	}

	public function profileUpdate(Request $request)
	{
		$user = Auth::user();
		$user->name = $request->get('name');
		$user->tel = $request->get('tel');
		$user->email = $request->get('email');


		if($request->file('avatar')){
			$file_avatar       = $request->file('avatar');
			$file_avatar_name  = $file_avatar->getClientOriginalName();
			$file_avatar_path   = $file_avatar->move('uploads/avatar', $user->id.'_'.$file_avatar_name);
			$user->avatar = str_replace("uploads/","",$file_avatar_path);
		}

		if($request->file('password')){
			$user->password    = bcrypt($request->file('password'));
		}

		$user->save();

		return redirect()->back();
	}
}
