<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visibility extends Model
{
    protected $table = 'visibility';

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function events(){
        return $this->hasMany('App\Events');
    }
}
