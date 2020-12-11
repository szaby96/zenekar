<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    public function user(){
        return $this->belongsTo('App\User', 'created_user_id');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'event_users');
    }

    public function visibility (){
        return $this->belongsTo('App\Visibility');
    }
    public function instrument (){
        return $this->belongsTo('App\Instrument');
    }
}
