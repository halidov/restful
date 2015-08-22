<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClientController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['is_client'] = true;

        $validation = \Validator::make($request->all(), [
            'name' => 'required|min:3',
            'login' => 'required|min:3|unique:users',
            'password' => 'required|min:5',
        ]);

        if($validation->fails())
            return response($validation->errors()->all(), 400);

        $client = new \App\User($input);

        \Auth::user()->clients()->save($client);

        $client->savePhoto($request->file('photo'));

        return $client;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($client)
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
    public function update(Request $request, \App\User $user)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'min:3',
            'login' => 'min:3|unique:users',
            'password' => 'min:5',
        ]);

        if($validation->fails())
            return response($validation->errors()->all(), 400);
            
        if($user->is_client && $user->admin_id == \Auth::user()->id) {

            $user->update($request->all());

            $user->savePhoto($request->file('photo'));

            return $user;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(\App\User $user)
    {
        if($user->is_client && $user->admin_id == \Auth::user()->id) {
            return (string) $user->delete();
        }
    }
}
