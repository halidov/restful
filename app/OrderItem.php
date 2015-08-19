<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['status', 'amount'];

    public function order() {
    	return $this->belongsTo('App\Order');
    }

    public function food() {
    	return $this->belongsTo('App\Food');
    }
}
