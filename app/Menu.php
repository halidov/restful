<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

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
