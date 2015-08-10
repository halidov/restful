<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WaiterClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(\App\User $waiter)
    {
        if($waiter->accessable())
            return $waiter->clients;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, \App\User $waiter)
    {
        $client_id = $request->input('client_id');
        if($waiter->accessable() && \App\User::find($client_id)->accessable()) {
            $waiter->clients()->attach($client_id);
            return $waiter->clients;
        }   
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(\App\User $waiter, \App\User $client)
    {
        if($waiter->accessable() && $client->accessable())
            $waiter->clients()->detach($client->id);
    }
}
