<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'assignments';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function instrument (){
        return $this->belongsTo('App\Instrument');
    }

    public function composition(){
        return $this->belongsTo('App\Composition');
    }

}
