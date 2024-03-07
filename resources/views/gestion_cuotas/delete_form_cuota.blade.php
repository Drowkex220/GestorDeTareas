@extends('layout.plantilla')

@section('title', 'Confirmar borrar Cuota')

@section('content')
    <h1>Borrar Cuota</h1>

    <form action="{{ route('deleteCuota', ['id' => $cuota->id]) }}" method="POST"
        class ="formulario form form-control">
        @csrf


        <h4>Datos</h4>

        <div class="data">
            <p><strong>Concepto:</strong> {{ $cuota->concepto }}</p>
            <p><strong>Estado: </strong>{{ $cuota->importe }}</p>

        </div>
        <button type="submit" class=" btn btn-danger">Borrar</button>

    </form>
@endsection
