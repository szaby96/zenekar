<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';

    public function user(){
        return $this->belongsTo('App\User', 'created_user_id');
    }

    public function photos(){
        return $this->hasMany('App\Photo');
    }
}
