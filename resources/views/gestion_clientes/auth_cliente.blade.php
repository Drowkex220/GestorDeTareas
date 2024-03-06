@extends('layout.plantilla')

@section('title', 'Formulario de clientes')

@section('content')
    <style>
        .datos {
            margin-bottom: 40px
        }
    </style>
    <h1 class="mb-4">Formulario de Clientes</h1>

    <form action="{{ route('checkAuthCliente') }}" method="POST" class="formulario form form-control">
        @csrf

        <h4>Introduzca sus credenciales para continuar</h4>
        <input type="hidden" name="id" value="{{ old('id', isset($cliente) ? $cliente->id : '') }}">


        <div class="datos">

            <label for="cif">CIF</label>
            <input type="text" class="form-control" id="cif" name="cif" placeholder="CIF"
                value="{{ old('cif', isset($cliente) ? $cliente->cif : '') }}">


            <div class="text-danger" style="color: red">
                {{ isset($error) ? $error : '' }}</div>

        </div>




        <button type="submit" class="btn btn-primary">
            Guardar cliente
        </button>
    </form>


@endsection
