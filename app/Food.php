<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = ['name', 'price', 'descr'];

    public function accessable(\App\Menu $menu, \App\Category $category) {
    	return $category->id == $this->category_id && $category->accessable($menu);
    }
}
