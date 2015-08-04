<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'status'];

    public function categories() {
    	return $this->hasMany('App\Category');
    }

    public function admin() {
    	return $this->belongsTo('App\User', 'admin_id');
    }

    public function accessable() {
    	return $this->admin_id == \Auth::user()->id || $this->admin_id == \Auth::user()->admin_id;
    }

}
