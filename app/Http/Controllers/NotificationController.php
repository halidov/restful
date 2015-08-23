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
        $notifs = auth()->user()->notifications()->where('status', 0)->orderBy('id', 'desc')->get();

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
