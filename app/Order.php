<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['amount', 'status'];

    public function food() {
    	return $this->belongsTo('App\Food');
    }

    public function waiter() {
    	return $this->belongsTo('App\User', 'waiter_id');
    }
    public function client() {
    	return $this->belongsTo('App\User', 'client_id');
    }
}
