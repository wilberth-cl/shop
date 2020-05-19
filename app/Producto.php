<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [

            'nombre',
            'slug',
            'categoria_id',
            'cantidad',
            'precio_actual',
            'precio_anterior',
            'descuento',
            'descripcion_corta',
            'descripcion_larga',
            'especificaciones',
            'datos_deinteres',
            'visitas',
            'ventas',
            'estado',
            'activo',
            'sliderprincipal',

      ];

    public function Categoria()
    {
        return $this->belongsTo('App\Categoria');
    }

    public function imagenes(){
        return $this->morphMany('App\Imagen','imageable');
   }
}
