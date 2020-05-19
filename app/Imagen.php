<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $fillable = [
        'url'
    ];

    //no estarelacionada con la variable imageable
    public function imageable(){
        return $this->morphTo();
    }

}
