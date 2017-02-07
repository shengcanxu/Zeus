<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormNode extends Model
{
    public function form(){
        $this->belongsTo('App\Form');
    }
}
