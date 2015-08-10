<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name'];
    protected $dates = ['deleted_at'];

    public function menu() {
    	return $this->belongsTo('App\Menu');
    }

    public function accessable(\App\Menu $menu = null) {
        $access = true;

        if($menu)
            $access = $menu->id == $this->menu_id;
        else {
            $menu = $this->menu;
        }
        
    	return $access && $menu->accessable();
    }

    public function foods() {
    	return $this->hasMany('App\Food');
    }
}
