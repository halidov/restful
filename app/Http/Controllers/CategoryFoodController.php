<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryFoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(\App\Menu $menu, \App\Category $category)
    {
        if($category->accessable($menu))
            return $category->foods;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, \App\Menu $menu, \App\Category $category)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'required|min:3',
            'price' => 'required|integer|min:1',
        ]);

        if($validation->fails())
            return response($validation->errors()->all(), 400);

        if($category->accessable($menu)) {
            $food = new \App\Food($request->all());
            $category->foods()->save($food);

            $food->savePhotos(['photos'=>$request->file('photos'), 'remove_photos'=>$request->get('remove_photos'), 'main_photo'=>$request->get('main_photo')]);
            return $food;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, \App\Menu $menu, \App\Category $category, \App\Food $food)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'min:3',
            'price' => 'integer|min:1',
        ]);

        if($validation->fails())
            return response($validation->errors()->all(), 400);

        if($food->accessable($menu, $category)) {
            $food->update($request->all());

            $food->savePhotos(['photos'=>$request->file('photos'), 'remove_photos'=>$request->get('remove_photos'), 'main_photo'=>$request->get('main_photo')]);

            return $food;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(\App\Menu $menu, \App\Category $category, \App\Food $food)
    {
        if($food->accessable($menu, $category)) {
            return (string) $food->delete();
        }
    }
}
