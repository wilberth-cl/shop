@extends('plantilla.admin')

@section('titulo','Viendo Producto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.producto_c.index') }}">Productos</a></li>
    <li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('estilos')
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="/adminlte/plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection

@section('scripts')
<!-- Select2 -->
<script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>

  <!-- Editar de text -->
<script src="/ckeditor/ckeditor.js"></script>

<!-- Ekko Lightbox -->
<script src="/adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

<script>
    window.data = {
        editar:'Si',

        datos:{

            //nombres que se mandan a apiproducto que ya se han ligado a sus nombres en base de datos
            "nombre":"{{ $producto->nombre }}",
            "precio_anterior":"{{ $producto->precio_anterior }}",
            "porcentajededescuento":"{{ $producto->descuento }}"

        }

    }

    $(function () {
    //Initialize Select2 Elements
    $('#categoria_id').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    //usu de Lighbox

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    });
</script>

@endsection

@section('contenido')

<div id="apiproducto">
<form action="{{ route('admin.producto_c.update',$producto->id) }}" method="POST" enctype="multipart/form-data" >
    @csrf
    @method('PUT')

      <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->



          <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Datos generados automáticamente</h3>


              </div>
              <!-- /.card-header -->
              <div class="card-body">

                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">

                      <label>Visitas</label>
                      <input  class="form-control" type="number" id="visitas" name="visitas"
                        readonly value="{{ $producto->visitas }}"
                      >
                    </div>
                    <!-- /.form-group -->

                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group">

                      <label>Ventas</label>
                      <input  class="form-control" type="number" id="ventas" name="ventas"
                      readonly value="{{ $producto->ventas }}"
                      >
                    </div>
                    <!-- /.form-group -->

                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->




              </div>
              <!-- /.card-body -->
              <div class="card-footer">

              </div>
            </div>
            <!-- /.card -->



            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Datos del producto</h3>


              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">

                       <label for="nombre">Nombre</label>
                                <input v-model="nombre"
                                @blur="getProducto"
                                @focus="div_aparecer=false"
                                class="form-control" type="text" name="nombre" id="nombre" required="" readonly>

                        <label for="slug">Slug</label>
                                <input v-model="generarSlug"  class="form-control" type="text" name="slug" id="slug" readonly>
                                <div v-if="div_aparecer" v-bind:class="div_class_slug">
                                    @{{div_mensajeslug}}
                                </div><br v-if="div_aparecer">

                    </div>
                    <!-- /.form-group -->

                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group">




                      <label>Categoría</label>
                      <select disabled name="categoria_id" id="categoria_id" class="form-control" style="width: 100%;" >
                        @foreach($categorias as $categoria)

                         @if ($categoria->nombre == $producto->categoria->nombre)
                            <option value="{{ $categoria->id }}" selected="selected">{{ $categoria->nombre }}</option>
                         @else
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                         @endif
                        @endforeach
                      </select>

                      <label>Cantidad</label>
                      <input class="form-control" type="number" id="cantidad" name="cantidad"
                      readonly value="{{ $producto->cantidad }}"
                      >
                    </div>
                    <!-- /.form-group -->

                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->


              </div>
              <!-- /.card-body -->
              <div class="card-footer">

            </div>
          </div>

            <!-- /.card -->

            <!--- Sección de Precio -->

            <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Sección de Precios</h3>


                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">



                    <div class="col-md-3">
                      <div class="form-group">

                        <label>Precio anterior</label>



                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">$</span>
                        </div>
                        <input readonly v-model="precio_anterior"
                        class="form-control" type="number" id="precio_anterior" name="precio_anterior" min="0" value="0" step=".01">
                      </div>

                      </div>
                      <!-- /.form-group -->

                    </div>
                    <!-- /.col -->



                    <div class="col-md-3">
                      <div class="form-group">

                        <label>Precio actual</label>
                         <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">$</span>
                        </div>
                        <input readonly v-model="precioactual"
                         class="form-control" type="number" id="precioactual" name="precioactual" min="0" value="0" step=".01">
                      </div>

                      <br>
                      <span id="descuento">

                        @{{ generardescuento }}


                      </span>
                      </div>
                      <!-- /.form-group -->

                    </div>
                    <!-- /.col -->




                    <div class="col-md-6">
                      <div class="form-group">

                        <label>Porcentaje de descuento</label>
                         <div class="input-group">
                        <input readonly v-model="porcentajededescuento"
                        class="form-control" type="number" id="porcentajededescuento" name="porcentajededescuento" step="any" min="0" max="100" value="0" >    <div class="input-group-prepend">
                          <span class="input-group-text">%</span>
                        </div>

                      </div>

                      <br>
                      <div class="progress">
                          <div id="barraprogreso" class="progress-bar" role="progressbar" aria-valuenow="0"

                          v-bind:style="{width: porcentajededescuento+'%'}"

                          aria-valuemin="0" aria-valuemax="100">
                            @{{ porcentajededescuento }}%
                        </div>
                      </div>
                      </div>
                      <!-- /.form-group -->

                    </div>
                    <!-- /.col -->


                  </div>
                  <!-- /.row -->


                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
              </div>
              <!-- /.card -->
<!--- / Sección de Precio -->





       <div class="row">
              <div class="col-md-6">

                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Descripciones del producto</h3>
                  </div>
                  <div class="card-body">
                    <!-- Date dd/mm/yyyy -->
                    <div class="form-group">
                      <label>Descripción corta:</label>

                      <textarea readonly class="form-control ckeditor" name="descripcion_corta" id="descripcion_corta" rows="3">
                        {!! $producto->descripcion_corta !!}
                      </textarea>

                    </div>
                    <!-- /.form group -->

                   <div class="form-group">
                       <label>Descripción larga:</label>

                      <textarea readonly class="form-control ckeditor" name="descripcion_larga" id="descripcion_larga" rows="5">
                        {!! $producto->descripcion_larga !!}
                      </textarea>

                    </div>

                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

           </div>
            <!-- /.col-md-6 -->




              <div class="col-md-6">

                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Especificaciones y otros datos</h3>
                  </div>
                  <div class="card-body">
                    <!-- Date dd/mm/yyyy -->
                    <div class="form-group">
                    <label>Especificaciones:</label>

                      <textarea readonly class="form-control ckeditor" name="especificaciones" id="especificaciones" rows="3">
                        {!! $producto->especificaciones !!}
                      </textarea>

                    </div>
                    <!-- /.form group -->

                   <div class="form-group">
                      <label>Datos de interes:</label>

                      <textarea readonly class="form-control ckeditor" name="datos_deinteres" id="datos_de_interes" rows="5">
                        {!! $producto->datos_deinteres !!}
                      </textarea>

                    </div>

                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

           </div>
            <!-- /.col-md-6 -->



          </div>
          <!-- /.row -->


<!-- subir imagenes -->

             <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Imágenes</h3>


              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="form-group">

                   <label for="archivosimagenes">Edite para:</label>
                   <div class="description">
                        <ul>
                            <li type="square">Subir más imágenes.</li>
                            <li type="square">Eliminar imágenes.</li>
                        </ul>
                   </div>

                </div>


              </div>


              <!-- /.card-body -->
              <div class="card-footer">

              </div>
            </div>
            <!-- /.card -->
<!-- /.subir imagenes -->
<!-- lightbox -->




<div class="card card-primary">
    <div class="card-header">
      <div class="card-title">
        Galería de imágenes
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        @if ( $producto->imagenes->count()>0)
            @foreach ($producto->imagenes as $imagen)
                <div id="idimagen-{{$imagen->id}}" class="col-sm-2">
                    <a href="{{ $imagen->url }}" data-toggle="lightbox" data-title="Imagen: {{ $imagen->id }} {{ $producto->nombre }}-{{ $producto->categoria->nombre }}" data-gallery="gallery">
                        <img style="height:150px; width:auto; vertical-align:middle;"  id="alineasion"  src="{{ $imagen->url }}" class="img-fluid mb-2 rounded" />
                    </a>
                </div>
            @endforeach
        @else
        Sin imágenes para mostrar.
        @endif

      </div>
    </div>
  </div>








<!-- /.lightbox -->

          <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Administración</h3>
              </div>
              <!-- /.card-header -->
          <div class="card-body">

           <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">


                      <label>Estado</label>
                      <select disabled name="estado" id="estado" class="form-control" style="width: 100%;">
                        @foreach($estadosProductos as $estado)

                         @if ($estado == $producto->estado)
                            <option value="{{ $estado }}" selected="selected">{{ $estado }}</option>
                         @else
                            <option value="{{ $estado }}">{{ $estado }}</option>
                         @endif
                        @endforeach
                      </select>


                    </div>
                    <!-- /.form-group -->

                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                        <!-- checkbox -->
                        <div class="form-group clearfix">
                          <div class="custom-control custom-checkbox">
                            <input disabled type="checkbox" class="custom-control-input" id="activo" name="activo"
                            @if ($producto->activo=='Si')
                                checked
                            @endif
                            >
                            <label class="custom-control-label" for="activo">Activo</label>
                         </div>

                        </div>

                        <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input disabled type="checkbox"  class="custom-control-input" id="sliderprincipal" name="sliderprincipal"
                          @if ($producto->sliderprincipal=='Si')
                                checked
                            @endif
                          >
                          <label class="custom-control-label" for="sliderprincipal">Aparece en el Slider principal</label>
                        </div>
                      </div>

                      </div>



           </div>
                <!-- /.row -->

           <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">

                        <a class="btn btn-danger" href="{{ route('cancelar','admin.producto_c.index') }}">Sin Cambios</a>
                        <a class="btn btn-outline-success float-right" href="{{ route('admin.producto_c.edit',$producto->slug) }}">Editar</a>

                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->




           </div>
                <!-- /.row -->

              </div>

              <!-- /.card-body -->
              <div class="card-footer">

              </div>
            </div>
            <!-- /.card -->

          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        </form>
    </div>

     @endsection
