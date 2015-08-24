<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        for($i=0;$i<15;$i++) {
            $notifs = auth()->user()->notifications()->where('status', 0)->orderBy('id', 'desc')->get();

            if($notifs->isEmpty()) {
                sleep(1);
            } else {
                return $notifs;
            }
        }

        return $notifs;
    }


    public function store(Request $request) {
        $me = auth()->user();

        if($me->is_client && $request['bill_please']) {
            $waiter = $me->orders->first()->load('waiter')->waiter;
            \App\Notification::add($me->toArray(), 'bill_please', $waiter);
        } else {
            auth()->user()->notifications()->update(['status'=>1]);
        }
        
        return 'OK';
    }

}
