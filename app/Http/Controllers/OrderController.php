<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {   
        return \Auth::user()->orders()->where('status', '!=', 2)->orderBy('id', 'desc')->get()->load('items.food');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $items = $request->get('items');
        $me = \Auth::user();

        $order = new \App\Order;
        $order->client()->associate($me);

        $my_orders = $me->orders;

        if($my_orders->isEmpty()) {
            foreach ($me->waiters()->online()->get() as $waiter) {
                \App\Notification::add($me->toArray(), 'serve_me', $waiter);
            }
        } else {
            $my_order = $my_orders->first()->toArray();

            if($my_order['waiter_id']) {
                $waiter = \App\User::find($my_order['waiter_id']);
                $order->waiter()->associate($waiter);
                \App\Notification::add($me->toArray(), 'serve_me_again', $waiter);
            }
        }
        
        $order->save();

        foreach ($items as $item) {
            $food = \App\Food::find($item['food']);
            if($food->category->menu->admin_id == $me->admin_id) {
                
                $item = new \App\OrderItem($item);

                $item->food()->associate($food);
                $item->order()->associate($order);

                $item->save();
            }
        }

        return $order->load('items.food');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(\App\Order $order)
    {
        if($order->client_id == \Auth::user()->id) {
            return $order->load('waiter');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
