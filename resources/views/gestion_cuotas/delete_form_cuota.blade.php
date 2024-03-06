@extends('layout.plantilla')

@section('title', 'Confirmar borrar Cuota')

@section('content')
    <h1>Borrar Cuota</h1>

    <form action="{{ route('deleteCuota', ['id' => $cuota->id]) }}" method="POST"
        class ="formulario form form-control">
        @csrf


        <h2>Datos</h2>

        <div class="data">
            <p>Concepto: {{ $cuota->concepto }}</p>
            <p>Estado: {{ $cuota->importe }}</p>

        </div>
        <button type="submit" class=" btn btn-danger">Borrar</button>

    </form>
@endsection
