@extends('plantilla.admin')

@section('titulo','Administración de Productos')

@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('contenido')

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style type="text/css">

  .ui-autocomplete-loading {
    background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  }

    .btnver, .btnedit, .btndelet {
      color:lightseagreen;
    }
    .btnver:hover{
      background-color:#007bff;
      color:#ffffff;
    }
    .btnedit:hover{
      background-color:#28a745;
      color:#ffffff;
    }
    .btndelet:hover{
      background-color:#dc3545;
      color:#ffffff;
    }

    .highlight{
      background: yellow;
      font-weight: bold;
    }

</style>

@section('scripts')
 
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>

  /******************************************************
  * Sombrea donde esta la palabra
  * Video tutorial
  * https://www.youtube.com/watch?v=cEX7WD5Vpgk
  *****************************************************/

  $(document).ready(function() {

    $("#birds").keyup(function(){
      searchHighlight($(this).val());
    });

/*    //nos crea una lista de posibles valores
    $( "#birds" ).autocomplete({
      source: "{{url('/api/autocompletar')}}",
      autoFocus: true,
    
    //Con el metodo select sabes cual emos seleccionado  
      select: function(event, ui) {
        //mandamos el valor seleccionado al input
        $( "#birds" ).val(ui.item.value);
        //llamamos a la funcion log
        log();
      }, 

    });
    //funcion log
    function log() {
      //Preguntamos si exite el id Para hacer un click al boton
       $( "#mandar" ).trigger( "click" );
    }
*/
  });  

  function searchHighlight(searchText){
    
    if(searchText){
      var content = $("#buscaaqui").text();
      var searchExp = new RegExp(searchText,"gi");
      var matches = content.match(searchExp);
      //alert(matches);
      if (matches) {
          $("#buscaaqui").html(content.replace(searchExp, function(match){
            return '<span class="highlight">'+match+'</span>';
          }));
      }
    }
  }

  </script>
@endsection
        <!-- /.row -->
<div id="confirmareliminar" class="row">

<span style="display:none" id="urlbase" >{{ route('admin.producto_c.index') }}</span>

    @include('custom.modal-eliminar')

            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Sección de Administración</h3>

                  <div class="card-tools">

                      <form>
                        <div class="input-group input-group-sm" style="width:550px;">
                            <label for="birds"></label>
                            <input id="birds" type="text" name="nombre" class="form-control float-right" autocomplete="off" placeholder="Buscar o mostrar todos"
                            >
                          <!--- value="{{ request()->get('nombre') }}" --->
                        <div class="input-group-append">
                            <button id="mandar" type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                        </div>
                    </form>

                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 440px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead  class="tablep" >
                      <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Activo</th>
                        <th>Categoría</th>
                        <th colspan="2"></th>
                        <th><a title="Nuevo Producto" class="btn btn-outline-primary" href="{{ route('admin.producto_c.create') }}"><strong>Nuevo</strong></a></th>
                      </tr>
                    </thead>
                    <tbody>

                    @if ($productos->count()>0)
                            @foreach ($productos as $prod)
                                <tr>
                                    <td style="vertical-align:middle;">{{ $prod->id }}</td>
                                    <td>
                                    @if ($prod->imagenes->count()<=0)
                                        <img style="height:50px; width:50px; vertical-align:middle;" src="/imagenes/default.png" class="rounded" alt="">
                                    @else
                                            <img style="height:50px; width:50px; vertical-align:middle;" src="{{ $prod->imagenes->random()->url }}" class="rounded" alt="">
                                    @endif
                                    </td>
                                    <td style="vertical-align:middle;">{{ $prod->nombre }}</td>
                                    <td style="vertical-align:middle;">{{ $prod->estado }}</td>
                                    <td style="vertical-align:middle;">{{ $prod->activo }}</td>
                                    <td style="vertical-align:middle;">{{ $prod->categoria->nombre }}</td>

                                <td style="vertical-align:middle;"><a title="Ver" class="btn btnver" href="{{ route('admin.producto_c.show',$prod->slug) }}"><i style="" class="far fa-eye"></i></a></td>
                                <td style="vertical-align:middle;"><a title="Editar" class="btn btnedit" href="{{ route('admin.producto_c.edit',$prod->slug) }}"><i style="" class="far fa-edit"></i></a></td>
                                <td style="vertical-align:middle;"><a title="Eliminar" class="btn btndelet" href="{{ route('admin.producto_c.index') }}"
                                    v-on:click.prevent="peticion_elimiar({{ $prod->id }})"
                                    ><i style="" class="far fa-trash-alt"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:right;">No hay Productos</td>
                            </tr>
                        @endif
                    </tbody>
                  </table>



                  {{ $productos->appends($_GET)->links() }}
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>

<div class="ui-widget" style="margin-top:2em; font-family:Arial">
  Result:
  <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>

 <p id="buscaaqui" > wilberth qwertyuiopasdfghjk  poikjhgfdsvbn  lkjnbvfde wertyuioplmnbvc asxcvghuiol jhgfrdewqasdxcvbn polkmnbvcxzqwertyui htrdcvhj rtgvbn hgfdedf piujmnbvcsw kuytresdcfvgh </p>

@endsection
