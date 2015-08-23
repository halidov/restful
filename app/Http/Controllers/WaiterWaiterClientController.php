<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WaiterWaiterClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return \Auth::user()->clients;
    }

    public function update(Request $request, \App\User $client) {
    	$me = auth()->user();

    	$my_client = $me->clients->where('id', $client->id);

    	if(!$my_client->isEmpty()) {
    		if($request->get('clear'))
    			$client->orders()->where('status', 1)->update(['status'=>2]);
    	}
    }
}
