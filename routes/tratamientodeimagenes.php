<?php

    //Codigo para Validar si (producto/usuario) cuenta con una imagen ya existente
    $usuario = App\User::find(1); //buscando un Usuario

    $imagen = $usuario->imagen;

    if ($imagen) {
        return 'si tiene';
    } else {
        return 'no tiene';
    }



    // Guardar imagen de usuario con SAVE()
    $imagen = new App\Imagen(['url'=>'imagenes/avatar.png']);

    $usuario = App\User::find(1); //buscamos al Usuario

    $usuario->imagen()->save($imagen);

    return $usuario;


    // Guardar imagen de usuario con CREATE()
    $usuario = App\User::find(1); //buscamos al Usuario

    $usuario->imagen()->create([
       'url' => 'imagenes/avatar2.png',
    ]);

    return $usuario;

    // Guardar imagen de usuario con ARREGLO
    $imagen = [];
    $imagen['url'] = 'imagenes/avatar2.png';

    // Guardar imagen de usuario
    $usuario = App\User::find(1); //buscamos al Usuario

    $usuario->imagen()->create([
        'url' => 'imagenes/avatar2.png',
    ]);

    return $usuario;




    //Obtener informaciones de las imagenes a travez del usuario
    $usuario = App\User::find(1);

    return $usuario->imagen->url;




    // Guardar multiples imagenes de productos
    $producto = App\Producto::find(2);

    $producto->imagenes()->saveMany([
        new App\Imagen(['url'=>'imagenes/avatar.png']),
        new App\Imagen(['url'=>'imagenes/avatar2.png']),
        new App\Imagen(['url'=>'imagenes/avatar3.png']),
    ]);

    return $producto;

     // Guardar multiples imagenes de productos usando CREATEMANY() y ARREGLOS
    $imagen = [];

    $imagen[]['url'] = 'imagenes/avatar.png';
    $imagen[]['url'] = 'imagenes/avatar2.png';
    $imagen[]['url'] = 'imagenes/avatar3.png';
    $imagen[]['url'] = 'imagenes/avatara.png';
    $imagen[]['url'] = 'imagenes/avatara.png';
    $imagen[]['url'] = 'imagenes/avatara.png';

    $producto = App\Producto::find(3);

    $producto->imagenes()->createMany($imagen);

    return $producto->imagenes;




    //Obtener informaciones de las imagenes a travez del producto
    $producto = App\Producto::find(2);

    return $producto->imagenes;


    //Actualizar imagen Usuario
    $usuario = App\User::find(1);
    $usuario->imagen->url='imagenes/avatar2.png';
    $usuario->push();

    return $usuario->imagen;

    //Actualizar una imagen especifica de todas las imagenes pertenecientes a un Producto
    $producto = App\Producto::find(2);
    $producto->imagenes[0]->url='iamgenes/avatar3.png';
    $producto->push();

    return $producto->imagenes;

    //Buscar producto por medio de imagen
    $imagen=App\Imagen::find(11);
    return $imagen->imageable;

    //Buscar imagens por medio de producto
    $producto=App\Producto::find(3);
    return $producto->imagenes;         // Ó return $producto->imagenes[1];

    //Delimitar la busqueda de imagenes especificas
    $producto=App\Producto::find(3);
    return $producto->imagenes()->where('url','imagenes/avatara.png')->get();

    //ordenar
    $producto=App\Producto::find(3);
    return $producto->imagenes()->where('url','imagenes/avatara.png')->orderBy('id','DESC')->get();

    //contar registros de usuario
    $usuario = App\User::withCount('imagen')->get();
    $usuario = $usuario->find();
    return $usuario;

    // contar las imagenes pertenecientes a un usuario
    $usuario = App\User::withCount('imagen')->get();
    $usuario = $usuario->find(1);
    return $usuario->imagen_count;;

    // contar las imagenes pertenecientes a un producto
    $productos = App\Producto::withCount('imagenes')->get();
    $productos = $productos->find(2);
    return $productos->imagenes_count;

    $productos = App\Producto::find(2);
    return $productos->loadCount('imagenes');

    // Carga Diferida de imagenes
    $producto = App\Producto::find(2);
    $imagen = $producto->imagen;
    $categoria = $producto->categoria;

    //Carga previa ( eager loading() ) LA MEJOR MANERA
    $producto = App\Producto::with('imagenes')->get();
    return $producto;

    //Carga previa ( eager loading() ) LA MEJOR MANERA
    $usuario = App\User::with('imagen')->get();
    return $usuario;

    // Carga previa
    $usuario = App\User::with('imagen')->find(1);
    return $usuario->imagen->url;

    // Carga previa de multiples relaciones Producto - imagenes - categoria de todo
    $producto = App\Producto::with('imagenes','categoria')->get();
    return $producto;

    // Carga previa de multiples relaciones Producto - imagenes - categoria de un producto especifico
    $producto = App\Producto::with('imagenes','categoria')->find(2);
    return $producto;

    // Carga previa de multiples relaciones Producto - imagenes - categoria de un producto especifico
    // con Atributos especificos
    $producto = App\Producto::with('imagenes:id,imageable_id,url','categoria:id,nombre,slug')->find(2);
    return $producto;

    //Eliminar imagen especifica
    $producto = App\Producto::find(2);
    $producto->imagenes[0]->delete();
    return $producto;

    //Eliminar TODAS las imagenes
    $producto = App\Producto::find(2);
    $producto->imagenes()->delete();
    return $producto;


?>

