@extends('plantilla.admin')

@section('titulo','Administración de Categorías')

@section('breadcrumb')
    <li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('contenido')

<style>
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
    </style>

        <!-- /.row -->
<div id="confirmareliminar" class="row">

<span style="display:none" id="urlbase" >{{ route('admin.categoria_c.index') }}</span>

    @include('custom.modal-eliminar')

            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Sección de administración</h3>

                  <div class="card-tools">

                      <form>
                        <div class="input-group input-group-sm" style="width:550px;">
                            <input type="text" name="nombre" class="form-control float-right" placeholder="Buscar o mostrar todos" value="{{ request()->get('nombre') }}">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                        </div>
                    </form>

                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 440px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Descripción</th>
                        <th>Fecha creación</th>
                        <th>Fecha modificación</th>
                        <th colspan="2"></th>
                        <th><a title="Nueva Categoría" class="btn btn-outline-primary" href="{{ route('admin.categoria_c.create') }}"><strong>Nueva</strong></a></th>

                      </tr>
                    </thead>
                    <tbody>
                       @foreach ($categorias as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td>{{ $cat->nombre }}</td>
                                <td>{{ $cat->slug }}</td>
                                <td>{{ $cat->descripcion }}</td>
                                <td>{{ $cat->created_at}}</td>
                                <td>{{ $cat->updated_at}}</td>

                            <td><a title="Ver" class="btn btnver" href="{{ route('admin.categoria_c.show',$cat->slug) }}"><i style="" class="far fa-eye"></i></a></td>
                            <td><a title="Editar" class="btn btnedit" href="{{ route('admin.categoria_c.edit',$cat->slug) }}"><i style="" class="far fa-edit"></i></a></td>
                            <td><a title="Eliminar" class="btn btndelet" href="{{ route('admin.categoria_c.index') }}"
                                v-on:click.prevent="peticion_elimiar({{ $cat->id }})"
                                ><i style="" class="far fa-trash-alt"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                  {{ $categorias->appends($_GET)->links() }}
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>

@endsection
