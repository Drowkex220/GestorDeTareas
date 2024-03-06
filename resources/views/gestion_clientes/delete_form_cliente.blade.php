@extends('layout.plantilla')

@section('title', 'Confirmar borrar Cliente')

@section('content')
    <h1>Borrar Cliente</h1>

    <form action="{{ route('deleteCliente', ['id' => $cliente->id]) }}" method="POST"
        class ="formulario form form-control">
        @csrf


        <h2>Datos</h2>

        <div class="data">
            <p>CIF: {{ $cliente->cif }}</p>
            <p>Nombre: {{ $cliente->nombre }}</p>

        </div>
        <button type="submit" class=" btn btn-danger">Borrar</button>

    </form>
@endsection
