<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function nodes(){
        return $this->hasMany('App\FormNode');
    }
}
