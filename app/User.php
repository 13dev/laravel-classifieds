<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable 
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'name', 'email', 'username', 'last_name', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'remember_token',
    ];

    public static function boot() {

        parent::boot();
        
        static::creating(function($user) {
            $user->emailtoken = str_random(36);
        });
    }

    public function confirmEmail() {
        $this->verified = true;
        $this->emailtoken = null;
        $this->save();
    }

    public function setPasswordAttribute($password)
    {
        if(Hash::needsRehash($password)) {
            $password = bcrypt($password);
        }
        $this->attributes['password'] = $password;
    }

    public function items()
    {
        return $this->hasMany('App\Item');
    }

}
