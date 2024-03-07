@extends('layout.plantilla')

@section('title', 'Confirmar borrar Cliente')

@section('content')
    <h1>Borrar Cliente</h1>

    <form action="{{ route('deleteCliente', ['id' => $cliente->id]) }}" method="POST"
        class ="formulario form form-control">
        @csrf


        <h4>Datos</h4>

        <div class="data">
            <p><strong>CIF:</strong> {{ $cliente->cif }}</p>
            <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>

        </div>
        <button type="submit" class=" btn btn-danger">Borrar</button>

    </form>
@endsection
