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
        return \Auth::user()->menus()->orderBy('id', 'desc')->get(); 
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

        $menu = new \App\Menu($request->all());
        \Auth::user()->menus()->save($menu);
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
        $validation = \Validator::make($request->all(), [
            'name' => 'min:3',
        ]);

        if($validation->fails())
            return response($validation->errors()->all(), 400);

        if($menu->accessable()) {
            $input = $request->all();
            if(!empty($input['status'])) {
                \Auth::user()->menus()->update(['status'=>false]);
            }
            $menu->update($request->all()); 
            return $menu;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(\App\Menu $menu)
    {
        if($menu->accessable()) {
            return (string) $menu->delete();
        }
    }
}
