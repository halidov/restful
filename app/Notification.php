<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	public static $TYPES = [
		'serve_me' => 1,
		'hes_mine' => 2,
		'ur_mine'	=> 3,
		'serve_me_again' => 4,
		'bill_please'	=> 5,
	];

	protected $casts = [
        'data' => 'array',
    ];

    protected $fillable = ['data', 'status', 'type'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public static function add($data, $type, $user, $target = 0) {
    	$notif = new \App\Notification;
        $notif->type = \App\Notification::$TYPES[$type];
        $notif->user()->associate($user);
        $notif->data = $data;
        if($target)
        	$notif->target_id = $target;

        $notif->save();

        return $notif;
    }
}
