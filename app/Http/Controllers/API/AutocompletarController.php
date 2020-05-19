<?php

namespace App\Http\Controllers\API;

use Illuminate\Contracts\Support\Jsonable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Producto;

class AutocompletarController extends Controller
{

     /**
     * Autocompletar busqueda prueba Rutas en api
     */
    public function index()
    {
        return view('search');
    }

    /**
     * Autocompletar busqueda Rutas en api
     */
    public function search(Request $request)
    {
        /*
        $search = $request->get('term');
        $Productos = Producto::where('nombre','Like',"%$search%")->orderBy('nombre','ASC')->get();

        $resultados = array();

        foreach ($Productos as $prod) {

            $encontrartexto = stristr($prod->nombre, $search);
            $prod->encontar = $encontrartexto;

            $recortarpalabra = substr($encontrartexto, 0, strlen($search));
            $prod->substr = $recortarpalabra;

            $prod->negrita = str_ireplace($search,"<b>$recortarpalabra</b>",$prod->nombre);

            array_push($resultados,$prod->negrita);
        }

        echo json_encode($resultados);

        */


        $search = $request->get('term');

        $productos = Producto::where('nombre', 'LIKE','%'.$search.'%')->get();

        $nombres = array();

        foreach ($productos as $producto) {
            array_push($nombres, $producto['nombre']);
        }


        echo json_encode($nombres);


         /*
        $palabraabuscar = $request->get('palabraabuscar');
        $Productos = Producto::where('nombre','Like',"%$palabraabuscar%")->orderBy('nombre','ASC')->get();

        $resultados = [];

        foreach ($Productos as $prod) {

            $encontrartexto = stristr($prod->nombre, $palabraabuscar);
            $prod->encontar = $encontrartexto;

            $recortarpalabra = substr($encontrartexto, 0, strlen($palabraabuscar));
            $prod->substr = $recortarpalabra;

            $prod->negrita = str_ireplace($palabraabuscar,"<b>$recortarpalabra</b>",$prod->nombre);

            $resultados[] = $prod;
        }

        return $resultados;

        */


    }

    public function indexdos()
    {
        return view('searchdos');
    }





}
