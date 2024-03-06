@extends('layout.plantilla')

@section('title', 'Lista de Tareas', )

@section('Lista de Tareas')
    @vite('resources/js/ver_tarea.js')
@endsection

@section('content')
    <h1>Listado de Tareas con componente Vue</h1>


    <div id="ver_tarea" data-nombre="Paco" data-tareas= {{ $tareas }}>

    </div>

@endsection
