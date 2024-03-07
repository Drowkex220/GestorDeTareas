@extends('layout.plantilla')

@section('title', 'Confirmar borrar usuario')

@section('content')
    <h1>Borrar Usuario</h1>

    <form action="{{ route('deleteUsuario', ['id' => $usuario->id]) }}" method="POST"
        class ="formulario form form-control">
        @csrf


        <h4>Datos</h4>

        <div class="data">
            <p><strong>Nombre de usuario: </strong>{{ $usuario->nombre_usuario }}</p>
            <p><strong>Permiso:</strong> {{ $usuario->permiso }}</p>

        </div>
        <button type="submit" class=" btn btn-danger">Borrar</button>

    </form>
@endsection
