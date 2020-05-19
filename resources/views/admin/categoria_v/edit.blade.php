@extends('plantilla.admin')

@section('titulo','Editar Categoría')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.categoria_c.index') }}">Categorías</a></li>
    <li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('contenido')

<!-- Default box -->
    <!-- Default box -->
<div id="apicategoria">
<form action="{{ route('admin.categoria_c.update',$cat->id) }}" method="POST">
    @csrf
    @method('PUT')
<span id="editar" style="display:none;">{{ $editar }}</span>
<span id="nombretemp" style="display:none;">{{ $cat->nombre }}</span>

        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Administración de categorías</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>

            <div class="card-body">
                            <div class="form-group">
                                <label for="nombre"><strong>Nombre</strong></label>
                                <input v-model="nombre"
                                @blur="getCategory"
                                @focus="div_aparecer=false"
                                class="form-control" type="text" name="nombre" id="nombre" required value="{{ $cat->nombre }} ">
                                <label for="slug"><strong>Slug</strong></label>
                                <input v-model="generarSlug"  class="form-control" type="text" name="slug" id="slug" readonly value="{{ $cat->slug }} ">
                                <div v-if="div_aparecer" v-bind:class="div_class_slug">
                                    @{{ div_mensajeslug }}
                                </div><br v-if="div_aparecer">
                                <label for="descripcion"><strong>Descripción</strong></label>
                                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="2" optional>{{ $cat->descripcion }}</textarea>
                            </div>
                </div>
            <!-- /.card-body -->
            <div class="card-footer">
            <a class="btn btn-danger" href="{{ route('cancelar','admin.categoria_c.index') }}">Cancelar</a>
                <input :disabled="btn_deshabilitado==1"
                type="submit" name="" value="Guardar" class="btn btn-primary float-right">
            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
    </form>
</div>
@endsection
