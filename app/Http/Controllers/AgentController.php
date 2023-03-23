<?php

namespace App\Http\Controllers;

use App\Agent;
use App\DeviceStock;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        if ($request->get('search')) {
            $search = $request->get('search');
            $agents = Agent::where('agent_name', 'LIKE', "%$search%")
            ->orwhere('tel', 'LIKE', "%$search%")
            ->orderby('id', 'desc')
            ->paginate(100);
        } else {
            $agents = Agent::orderBy('id', 'desc')->paginate(100);
        }
        
        return view('agents/index', compact('agents'));
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('agents/create');
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        Agent::create($request->except('_token'));
        
        return redirect('agents');
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $agent = Agent::find($id);
        $devices = DeviceStock::where('agent_use', $id)->paginate(100);
        return view('agents/edit', compact('agent', 'devices'));
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $agent = Agent::find($id);
        $agent->agent_name = $request->get('agent_name');
        $agent->tel = $request->get('tel');
        $agent->save();
        
        return redirect('agents');
        
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}
