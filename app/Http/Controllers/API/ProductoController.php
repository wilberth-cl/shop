<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Producto;
use App\Imagen;
use Illuminate\Support\Facades\File;

class ProductoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$cat = new Categoria();
        //$cat->nombre='Mujer';
        //$cat->slug='mujer';
        //$cat->descripcion='Ropa para mujer';
        //$cat->save();

        return Producto::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if( Producto::where('slug',$slug)->first()){
            return 'Slug existe';
        }else{
            return 'Slug disponible';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function eliminarimagen($id)
    {
        $imagen = Imagen::find($id);

        $archivo = substr($imagen->url,1); // lequita el primer \ "eslash"

        File::delete($archivo); //  eliminamos imagen almacenada
        //$eliminar = File::delete($archivo); //  eliminamos imagen de nuestro servidor

        $imagen->delete(); //eliminamos url-imagen y todo rastro en base de datos

        //return $archivo.' '.$eliminar;
    }

}
