<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(\App\Menu $menu)
    {
        if($menu->accessable())
            return $menu->categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, \App\Menu $menu)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if($validation->fails())
            return response($validation->errors()->all(), 400);

        $category = new \App\Category($request->all());
        $menu->categories()->save($category);

        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, \App\Menu $menu, \App\Category $category)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'min:3',
        ]);

        if($validation->fails())
            return response($validation->errors()->all(), 400);

        if($category->accessable($menu)) {
            $category->update($request->all());
            return $category;
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
