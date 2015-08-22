<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WaiterOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $me = \Auth::user()->load('clients');

        $clients = $me->clients->pluck('id');

        return \App\Order::whereIn('client_id', $clients)->whereNull('waiter_id')->orderBy('id', 'desc')->get()->load('client','items.food');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(\App\Order $order)
    {
        $me = \Auth::user();
        $client_id = $order->client_id;


        $my_client = $me->clients->where('id', $client_id);

        if(!$my_client->isEmpty()) {
            return $order->client->orders->load('food');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, \App\Order $order)
    {
        $me = \Auth::user();
        $client_id = $order->client_id;

        $my_client = $me->clients->where('id', $client_id);

        if(!$my_client->isEmpty()) {
            $status = $request->get('status');

            $orders = $order->client->orders;

            foreach ($orders as $o) {
                if($status == 1)
                    $o->waiter()->associate($me);
                $o->status = $status;
                $o->save();
            }

            return $orders;
        }
    }
}
