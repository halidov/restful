<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'price', 'descr', 'weight', 'evalue', 'cooking_time', 'ingredients'];

    public function accessable(\App\Menu $menu, \App\Category $category) {
    	return $category->id == $this->category_id && $category->accessable($menu);
    }

    public function category() {
    	return $this->belongsTo('App\Category');
    }

    public function orders() {
    	return $this->hasMany('App\Order');
    }
}
