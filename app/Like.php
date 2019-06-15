<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'likes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'video_id'];

    protected $casts = [
        'video_id' => 'integer',
        'user_id' => 'integer',
    ];



    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function video()
    {
        return $this->belongsTo('App\Video');
    }
}
