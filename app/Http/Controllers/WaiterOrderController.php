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

        return \App\Order::whereIn('client_id', $clients)->where('status', 0)->groupBy('client_id')->orderBy('created_at')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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

            $me->clients()->where('id', 1);
            $orders = $order->client->orders();

            if($status == 1) {
                $orders->update(['status'=>$status]);
                $order->waiter()->associate($me);
                $order->save();
            }

            if($status == 2) {
                $orders->update(['status'=>$status]);
            }

            return $orders->get();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
