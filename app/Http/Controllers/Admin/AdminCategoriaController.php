<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categoria;

class AdminCategoriaController extends Controller
{
    /**
     *
     * Activamos Middleware
     * para iniciar session antes de solicitar
     * entrar utilizando cualquier ruta
     *
     */
    public function __construct(){
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nombre = $request->get('nombre'); //para buscar

        if(!empty($nombre)){
            $categorias=Categoria::where('nombre','Like',"%$nombre%")->orderBy('nombre','ASC')->paginate(5);
            return view('admin.categoria_v.index',compact('categorias'));
        }else{
            $categorias=Categoria::orderBy('nombre','ASC')->paginate(5);
            return view('admin.categoria_v.index',compact('categorias'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categoria_v.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:50|unique:categorias,nombre',
            'slug'=>'required|max:50|unique:categorias,slug',
            'descripcion'=>'required',
        ]);
        Categoria::create($request->all());
        return redirect()->route('admin.categoria_c.index')->with('datos','¡Agregado Correntamente!');
        /*
        $cat = new Categoria();
        $cat->nombre=$request->nombre;
        $cat->slug=$request->slug;
        $cat->descripcion=$request->descripcion;
        $cat->save();
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $cat= Categoria::where('slug',$slug)->firstOrFail();
        $editar='si';
        return view('admin.categoria_v.show',compact('cat','editar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $cat= Categoria::where('slug',$slug)->firstOrFail();
        $editar='si';
        return view('admin.categoria_v.edit',compact('cat','editar'));
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
        $cat = Categoria::findOrFail($id);

        $request->validate([
            'tamanio_nombre'=>'required|max:50|unique:tamanios,tamanio_nombre,'.$tam->id,
            'tamanio_slug'=>'required|max:50|unique:tamanios,tamanio_slug,'.$tam->id,
        ]);

        $cat->fill($request->all())->save();
        return redirect()->route('admin.categoria_c.index')->with('datos','¡Actualizado Correntamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Categoria::findOrFail($id);
        $cat->delete();
        return redirect()->route('admin.categoria_c.index')->with('datos','¡Eliminado Correntamente!');
    }
}
