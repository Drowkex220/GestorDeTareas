@extends('layout.plantilla')

@section('title', 'Formulario de usuarios')

@section('content')
    <style>
        .datos {
            margin-bottom: 40px
        }
    </style>
    <h1 class="mb-4">Guardar Usuario</h1>

    <form action="{{ route('saveUsuario', ['modo' => $modo]) }}" method="POST" class="formulario form-control">
        @csrf


        <h4>Datos personales</h4>

        <input type="hidden" name="id" value="{{ old('id', isset($usuario) ? $usuario->id : '') }}">


        <div class="datos row ">

            <div class="col-6 p-2">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre"
                    value="{{ old('nombre', isset($usuario) ? $usuario->nombre : '') }}">

                @error('nombre')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6  p-2">
                <label for="nombre_usuario">Usuario</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario"
                    placeholder="Nombre de usuario"
                    value="{{ old('nombre_usuario', isset($usuario) ? $usuario->nombre_usuario : '') }}">

                @error('nombre_usuario')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6  p-2">
                <div>
                    @if (auth()->user()->permiso == 'admin')
                        <label for="permiso">Permiso:</label>
                        <select class="form-control" id="permiso" name="permiso">
                            <option value="operario">Operario</option>
                            <option value="admin">Administrador</option>
                        </select>
                    @else
                        <input type="hidden" id="permiso" name="permiso" value="admin">
                    @endif
                </div>


                @error('permiso')
                    <div class="text-danger" style="color: red">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-5  p-2"></div>


            <div class="col-5  p-2">
                <label for="contrasena">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contrasena"
                    value="{{ old('contrasena') }}">

                @error('contrasena')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

        </div>

        <br>
        <hr>
        <button type="submit" class="btn btn-primary">
            Guardar
        </button>
        </div>


    </form>


@endsection
