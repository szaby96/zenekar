<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    protected $table = 'instruments';

    public function users(){
        return $this->hasMany('App\User');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function sheetMusics(){
        return $this->hasMany('App\SheetMusic');
    }

}

