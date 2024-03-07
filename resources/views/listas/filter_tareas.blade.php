@extends('layout.plantilla')

@section('title', 'Lista de Tareas')

@section('content')
    <h1>Listado de Tareas</h1>

    @if (auth()->user()->permiso == 'admin')
        <a href="{{ route('addTareas') }}" class="btn btn-info"><i class="fa-solid fa-plus"></i> Añadir Tarea</a>
    @endif


    <form action="{{ route('resultadoFiltrado') }}" method="POST" class="formulario form form-control">
        @csrf
        <div class="form row">
            <div class="form-group col-6">
                <label for="campo">Campo:</label>
                <select class="form-control" id="campo" name="campo">
                    <option value="IDTarea">ID Tarea</option>
                    <option value="PersonaContactoNombre">Persona de Contacto (Nombre)</option>
                    <option value="Descripcion">Descripción</option>
                    <!-- Agrega más opciones según tus campos -->
                </select>
            </div>
            <div class="form-group col-6">
                <label for="termino">Término de búsqueda:</label>
                <input type="text" class="form-control" id="termino" name="termino">
            </div>
        </div>
        <button type="submit" class="btn btn-primary col-12">Buscar</button>
    </form>
    <table >
        <thead >
            <tr>
                <th>ID Tarea</th>
                <th>Persona de Contacto</th>
                <th>Descripción</th>
                <th>operario encargado</th>
                <th>Fecha de Creación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tareas as $tarea)
                <tr>
                    <td>{{ $tarea->IDTarea }}</td>
                    <td>{{ $tarea->PersonaContactoNombre }} {{ $tarea->PersonaContactoApellidos }}</td>
                    <td>{{ $tarea->Descripcion }}</td>
                    <td>{{ $tarea->OperarioEncargado }}</td>
                    <td>{{ $tarea->FechaCreacion }}</td>
                    <td>{{ $tarea->Estado }}</td>
                    <td>
                        @if (auth()->user()->permiso == 'operario')
                            <a href="{{ route('detallesTarea', ['id' => $tarea->IDTarea]) }}" class="btn btn-info"><i
                                    class="fa fa-eye"></i></a>
                        @endif

                        @if (auth()->user()->permiso == 'admin')
                            <a href="{{ route('modTareas', ['id' => $tarea->IDTarea]) }}"><i
                                    class="fa fa-edit fa-lg"></i></a>
                            <a href="{{ route('formDeleteTarea', ['id' => $tarea->IDTarea]) }}"><i
                                    class="fa fa-trash fa-lg"></i></a>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tareas->links() }}
@endsection
