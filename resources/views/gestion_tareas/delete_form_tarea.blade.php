@extends('layout.plantilla')

@section('title', 'Confirmar borrar Tarea')

@section('content')
    <h1>Borrar Tarea</h1>

    <form action="{{ route('deleteTarea', ['id' => $tarea->IDTarea]) }}" method="POST"
        class ="formulario form form-control">
        @csrf


        <h4>Datos</h4>

        <div class="data">
            <p><strong>Descripción: </strong>{{ $tarea->Descripcion }}</p>
            <p><strong>Estado:</strong> {{ $tarea->Estado }}</p>

        </div>
        <button type="submit" class=" btn btn-danger">Borrar</button>

    </form>
@endsection
