<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{ 

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {   
        return \App\Menu::orderBy('id', 'desc')->get(); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if($validation->fails())
            return response($validation->errors()->all(), 400);

        return \App\Menu::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(\App\Menu $menu)
    {
        return $menu;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, \App\Menu $menu)
    {  
        $menu->update($request->all()); 
        return $menu;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(\App\Menu $menu)
    {
        return (string) $menu->delete();
    }
}
