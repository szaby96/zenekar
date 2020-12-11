<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Right extends Model
{
    protected $table = 'rights';

    public function users(){
        return $this->hasMany('App\User');
    }

}
