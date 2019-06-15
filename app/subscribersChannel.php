<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscribersChannel extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['channel_id','user_id'];
}
