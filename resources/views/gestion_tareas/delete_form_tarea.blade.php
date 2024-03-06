@extends('layout.plantilla')

@section('title', 'Confirmar borrar Tarea')

@section('content')
    <h1>Borrar Tarea</h1>

    <form action="{{ route('deleteTarea', ['id' => $tarea->IDTarea]) }}" method="POST"
        class ="formulario form form-control">
        @csrf


        <h2>Datos</h2>

        <div class="data">
            <p>Descripción: {{ $tarea->Descripcion }}</p>
            <p>Estado: {{ $tarea->Estado }}</p>

        </div>
        <button type="submit" class=" btn btn-danger">Borrar</button>

    </form>
@endsection
