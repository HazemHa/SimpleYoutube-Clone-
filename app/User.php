<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function channels()
    {
        return $this->hasMany('App\Channel');
    }
    public function subsChannel(){
        return $this->hasMany('App\subscribersChannel');
    }
    public function myChannel()
    {
        return $this->hasOne('App\Channel');
    }


    public function videos()
    {
        return $this->hasMany('App\Video');
    }
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
   // public function SubsChannel()
  //  {
   //     return $this->hasManyThrough('App\Channel','App\subscribersChannel','id','id');
  //  }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function getJWTIdentifier() {

        return $this->getKey();

    }

    public function getJWTCustomClaims() {

        return [];

    }
}
