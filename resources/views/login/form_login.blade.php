@extends('layout.plantilla')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="login-content">


    <div style="text-align: center; border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 300px; margin: auto; margin-top: 50px;"
        class="form">

        <h1>Iniciar Sesión</h1>





        <form action="{{ route('authenticate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
                <input type="text" name="nombre_usuario" class="form-control" style="width: 100%;"
                    value="{{ old('nombre_usuario') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" style="width: 100%;"
                    value="{{ old('password') }}" required>
            </div>
            @error('nombre_usuario')
                <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror

            <div class="mb-3 form-check">
                <input type="checkbox" name="recordar" id="recordar">
                <label class="form-check-label" for="recordarCredenciales">Recordar credenciales</label>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
</div>
@endsection
