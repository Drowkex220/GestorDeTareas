@extends('layout.plantilla')

@section('title', 'Confirmar borrar usuario')

@section('content')
    <h1>Borrar Usuario</h1>

    <form action="{{ route('deleteUsuario', ['id' => $usuario->id]) }}" method="POST"
        class ="formulario form form-control">
        @csrf


        <h2>Datos</h2>

        <div class="data">
            <p>Nombre de usuario: {{ $usuario->nombre_usuario }}</p>
            <p>Permiso: {{ $usuario->permiso }}</p>

        </div>
        <button type="submit" class=" btn btn-danger">Borrar</button>

    </form>
@endsection
