@extends('layouts.app')

@section('template_title')
    Libro
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <!--  -->
                        <!--  <form class="row g-3"> -->
                          <form action="{{route('libros.index')}} method="get">
                            <div class="col-md-4">
                                <label for="validationServer01" class="form-label">Busqueda</label>
                                <input type="text" class="form-control is-valid" id="validationServer01"  required>
                                <div class="valid-feedback">
                                </div>
                            <!--  <div class="col-12"> -->
                           
                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </div>
                            </form>

                          <!--  -->
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Libros') }}
                            </span>

                             <div class="float-right">

                            <!--Boton  "Crear Pdf" -->
                            <a href="{{ route('libros.pdf') }}" class="btn btn-primary btn-sm "  data-placement="left">
                            {{ __('Descargar PDF') }}
                            </a>
                            &nbsp;
                            <!--Desde aquí esta el boton azul de crear "Crear Nuevo" -->
                            <a href="{{ route('libros.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                            {{ __('Crear Nuevo') }}
                            </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>N°</th>
                                        
										<th>Categoría </th>
										<th>Nombre</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($libros as $libro)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>
                                                
                                            {{ $libro->categoria->nombre }}
                                        
                                        </td>
											<td>{{ $libro->nombre }}</td>

                                            <td>
                                                <form action="{{ route('libros.destroy',$libro->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('libros.show',$libro->id) }}"><i class="fa fa-fw fa-eye"></i> Mostrar</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('libros.edit',$libro->id) }}"><i class="fa fa-fw fa-edit"></i> Editar</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Borrar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $libros->links() !!}
            </div>
        </div>
    </div>
@endsection
