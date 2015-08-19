<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['status'];

    public function waiter() {
    	return $this->belongsTo('App\User', 'waiter_id');
    }
    public function client() {
    	return $this->belongsTo('App\User', 'client_id');
    }

    public function items() {
        return $this->hasMany('App\OrderItem');
    }
}
