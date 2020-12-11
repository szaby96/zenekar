<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Composition extends Model
{
    protected $table = 'compositions';

    public function sheetMusics(){
        return $this->hasMany('App\SheetMusic');
    }
}
