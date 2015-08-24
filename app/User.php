<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['login', 'name', 'photo', 'email', 'password', 'is_waiter', 'is_client'];

    public function waiters() {
        if($this->is_client)
            return $this->belongsToMany('App\User', 'waiter_client', 'client_id', 'waiter_id');
        return $this->hasMany('App\User', 'admin_id')->where('is_waiter', 1);
    }

    public function clients() {
        if($this->is_waiter) {
            return $this->belongsToMany('App\User', 'waiter_client', 'waiter_id', 'client_id');
        }
        return $this->hasMany('App\User', 'admin_id')->where('is_client', 1);
    }

    public function orders() {
        if($this->is_waiter) {
            return $this->hasMany('App\Order', 'waiter_id');
        }
        return $this->hasMany('App\Order', 'client_id');
    }

    public function menus() {
        return $this->hasMany('App\Menu', 'admin_id');
    }

    public function menu() {
        return \App\Menu::where('admin_id', \Auth::user()->admin)->where('status', 1)->get();
    }

    public function accessable() {
        return $this->admin_id == \Auth::user()->id || $this->admin_id == \Auth::user()->admin_id;
    }

    public function savePhoto($photo) {

        if($photo) {
            \Storage::put('photos/users/' . $this->id . '.jpg', file_get_contents($photo->getRealPath()));
            $this->photo = TRUE;
            $this->save();
        }
    }

    public function notifications() {
        return $this->hasMany('App\Notification');
    }

    public function scopeOnline($query) {
        return $query->where('updated_at', '>', date("Y-m-d H:i:s", strtotime('-5 minutes')));
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

}
