<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable=['nombre','slug','descripcion'];

    public function Producto()
    {
        return $this->hasMany('App\Producto');
    }
}
