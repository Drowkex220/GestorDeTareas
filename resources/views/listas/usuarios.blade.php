@extends("layout.plantilla")

@section('title', 'Lista de usuarios')

@section('content')
<h1>Listado de usuarios</h1>

<a href="{{ route('addUsuario') }}" class="btn btn-info"><i class="fa-solid fa-plus"></i> Añadir usuario</a>

<table >
    <thead >
        <tr>
            <th>ID usuario</th>
            <th>Nombre</th>
            <th>Nombre de usuario</th>
            <th>Permiso</th>
            <th>Última sesión</th>
            <th>Acciones</th>

        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->id}}</td>
            <td>{{ $usuario->nombre }}</td>
            <td>{{ $usuario->nombre_usuario }}</td>
            <td>{{ $usuario->permiso }}</td>
            <td>{{ $usuario->last_sesion }}</td>
            <td>

                <a href="{{ route('modUsuario', ['id' => $usuario->id]) }}"><i
                    class="fa fa-edit fa-lg"></i></a>
            <a href="{{ route('formDeleteUsuario', ['id' => $usuario->id]) }}" ><i
                    class="fa fa-trash fa-lg"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $usuarios->links()}}
@endsection
