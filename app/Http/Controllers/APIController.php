<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;

class APIController extends Controller
{
	public function get_server(Request $request)
	{
		$q = $request->get('q');

		return Server::where('url', 'like', "%$q%")->paginate(null, ['url as text','id']);
    }
}
