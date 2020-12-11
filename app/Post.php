<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title', 'body', 'user_id', 'visibility_id', 'instrument_id'
    ];

    public function user (){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function instrument (){
        return $this->belongsTo('App\Instrument');
    }

    public function visibility (){
        return $this->belongsTo('App\Visibility');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

}
