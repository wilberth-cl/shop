<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Producto;
use App\Categoria;
use App\Imagen;
use Illuminate\Support\Facades\File;

class AdminProductoController extends Controller
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
            $productos=Producto::with('imagenes','categoria')->where('nombre','Like',"%$nombre%")->orderBy('nombre','ASC')->paginate(5);
            return view('admin.producto_v.index',compact('productos')); //** enviar el arreglo
        }else{
            $productos=Producto::with('imagenes','categoria')->orderBy('nombre','ASC')->paginate(5);
            return view('admin.producto_v.index',compact('productos')); //** de productos a la vista
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // mandamos todo lo que necesita el producto para crearlo
        $categorias=Categoria::orderBy('nombre','ASC')->get();//  Para mandar todo
        $estadosProductos = $this->estadosProductos();
        return view('admin.producto_v.create',compact('categorias','estadosProductos')); //** de productos a la vista
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
            'nombre'=>'required|max:50|unique:productos,nombre',
            'slug'=>'required|max:50|unique:productos,slug',
            'imagenes.*'=>'image|mimes:jpeg,png,jpg,gif,svg|max:3000',

        ]);

        //Guardamos las imagenes en la ruta fisica

        $urlimagenes = [];

        if($request->hasFile('imagenes')){
            $imagenes = $request->File('imagenes');
            //dd($imagenes);

            $diferenciador=1;
            foreach ($imagenes as $imagen) {
                $nombre = time().'_'.$diferenciador.'.'.$imagen->getClientOriginalExtension();

                $ruta = public_path().'/imagenes';

                $imagen->move($ruta,$nombre);

                $urlimagenes[]['url'] = '/imagenes/'.$nombre;

                $diferenciador=$diferenciador+1;
            }
           // return $urlimagenes;
        }

        $prod = new Producto;

        $prod->nombre           =$request->nombre;
        $prod->slug             =$request->slug;
        $prod->categoria_id     =$request->categoria_id;
        $prod->cantidad         =$request->cantidad;
        $prod->precio_actual    =$request->precioactual;
        $prod->precio_anterior  =$request->precio_anterior;
        $prod->descuento        =$request->porcentajededescuento;
        $prod->descripcion_corta=$request->descripcion_corta;
        $prod->descripcion_larga=$request->descripcion_larga;
        $prod->especificaciones =$request->especificaciones;
        $prod->datos_deinteres  =$request->datos_deinteres;
        $prod->estado           =$request->estado;
        $prod->activo           =$request->activo;
        $prod->sliderprincipal  =$request->sliderprincipal;

        if($request->activo){
            $prod->activo='Si';
        }else{
            $prod->activo='No';
        }

        if($request->sliderprincipal){
            $prod->sliderprincipal='Si';
        }else{
            $prod->sliderprincipal='No';
        }

        //Guardamos las imagenes en la ruta fisica
        $prod->save();

        //Guardamos las imagenes en la ruta fisica
        $prod->imagenes()->createMany($urlimagenes);

        return redirect()->route('admin.producto_c.index')->with('datos','¡Agregado Correntamente!');

        //return $prod;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug) //igual que el edit
    {
        $producto = Producto::with('imagenes','categoria')->where('slug',$slug)->firstOrFail();
        $categorias = Categoria::orderBy('nombre','ASC')->get();//  Para mandar todo
        $estadosProductos = $this->estadosProductos();
        //dd($estadosProductos);
        return view('admin.producto_v.show',compact('producto','categorias','estadosProductos')); //** de productos a la vista

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {

        $producto = Producto::with('imagenes','categoria')->where('slug',$slug)->firstOrFail();
        $categorias = Categoria::orderBy('nombre','ASC')->get();//  Para mandar todo
        $estadosProductos = $this->estadosProductos();
        //dd($estadosProductos);
        return view('admin.producto_v.edit',compact('producto','categorias','estadosProductos')); //** de productos a la vista

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
        $request->validate([
            'nombre'=>'required|max:50|unique:productos,nombre,'.$id,
            'slug'=>'required|max:50|unique:productos,slug,'.$id,
            'imagenes.*'=>'image|mimes:jpeg,png,jpg,gif,svg|max:3000',

        ]);

        $urlimagenes = [];

        if($request->hasFile('imagenes')){
            $imagenes = $request->File('imagenes');
            //dd($imagenes);

            $diferenciador=1;
            foreach ($imagenes as $imagen) {
                $nombre = time().'_'.$diferenciador.'.'.$imagen->getClientOriginalExtension();

                $ruta = public_path().'/imagenes';

                $imagen->move($ruta,$nombre);

                $urlimagenes[]['url'] = '/imagenes/'.$nombre;

                $diferenciador=$diferenciador+1;
            }
           // return $urlimagenes;
        }

        $prod = Producto::findOrFail($id);

        $prod->nombre           =$request->nombre;
        $prod->slug             =$request->slug;
        $prod->categoria_id     =$request->categoria_id;
        $prod->cantidad         =$request->cantidad;
        $prod->precio_actual    =$request->precioactual;
        $prod->precio_anterior  =$request->precio_anterior;
        $prod->descuento        =$request->porcentajededescuento;
        $prod->descripcion_corta=$request->descripcion_corta;
        $prod->descripcion_larga=$request->descripcion_larga;
        $prod->especificaciones =$request->especificaciones;
        $prod->datos_deinteres  =$request->datos_deinteres;
        $prod->estado           =$request->estado;
        $prod->activo           =$request->activo;
        $prod->sliderprincipal  =$request->sliderprincipal;

        if($request->activo){
            $prod->activo='Si';
        }else{
            $prod->activo='No';
        }

        if($request->sliderprincipal){
            $prod->sliderprincipal='Si';
        }else{
            $prod->sliderprincipal='No';
        }

        $prod->save();

        $prod->imagenes()->createMany($urlimagenes);

        return redirect()->route('admin.producto_c.edit',$prod->slug)->with('datos','¡Actualizado Correntamente!');

        //return $prod;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prod = Producto::with('imagenes')->findOrFail($id);

        foreach ($prod->imagenes as $imagen) {
            $archivo = substr($imagen->url,1); // lequita el primer \ "eslash"
            File::delete($archivo); //  eliminamos imagen almacenada
            $imagen->delete(); // eliminamos url-imagen y todo rastro en base de datos
        }
        $prod->delete();
        return redirect()->route('admin.producto_c.index')->with('datos','¡Eliminado Correntamente!');
        //return $prod;
    }

    public function estadosProductos()
    {
        return [
            'Sin estado',
            'Nuevo',
            'En Oferta',
            'Popular'
        ];
    }
}
