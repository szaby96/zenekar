<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SheetMusic extends Model
{
    protected $table = 'sheet_music';

    public function instrument(){
        return $this->belongsTo('App\Instrument');
    }

    public function composition(){
        return $this->belongsTo('App\Composition');
    }

}
