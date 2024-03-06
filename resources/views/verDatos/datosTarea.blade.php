@extends('layout.plantilla')

@section('title', 'Detalles de Tarea')

@section('content')
    <style>
        .Data {
            border: solid;
            border-radius: 5px;
            border-width: 1px;
            padding: 20px;
            margin-bottom: 20px
        }
    </style>
    <h1>Detalles de la Tarea</h1>



    <div class="tareaData" style="margin: 10px">
        <h4><strong>Tarea {{ $tarea['IDTarea'] }}</strong></h4>
        <div class="Data">
            <p><strong>NIF/CIF:</strong> {{ $tarea['NIF_CIF'] }}</p>
            <p><strong>Persona de contacto:</strong> {{ $tarea['PersonaContactoNombre'] }}
                {{ $tarea['PersonaContactoApellidos'] }}</p>
            <p><strong>Telefono de contacto:</strong> {{ $tarea['TelefonoContacto'] }}</p>
            <p><strong>Correo electronico:</strong> {{ $tarea['CorreoElectronico'] }}</p>
            <p><strong>Descripción:</strong> {{ $tarea['Descripcion'] }}</p>
        </div>
        <h4><strong>Ubicación</strong></h4>
        <div class="Data">
            <p><strong>Direccóon:</strong> {{ $tarea['Direccion'] }}</p>
            <p><strong>Población:</strong> {{ $tarea['Poblacion'] }}</p>
            <p><strong>Código Postal:</strong> {{ $tarea['CodigoPostal'] }}</p>
            <p><strong>ProvinciaCodigo:</strong> {{ $tarea['ProvinciaCodigo'] }}</p>
        </div>
        <h4>Estado y fechas</h4>
        <div class="Data">
            <p><strong>Estado:</strong> {{ $tarea['Estado'] }}</p>
            <p><strong>Fecha de creación:</strong> {{ $tarea['FechaCreacion'] }}</p>
            <p><strong>Fecha de realizacion:</strong> {{ $tarea['FechaRealizacion'] }}</p>
            <p><strong>Operario encargado:</strong> {{ $tarea['OperarioEncargado'] }}</p>

        </div>
        <h4>Anotaciones</h4>
        <div class="Data">
            <p><strong>Anotaciones anteriores:</strong> {{ $tarea['AnotacionesAnteriores'] ?: 'none' }}</p>
            <p><strong>Anotaciones posteriores:</strong> {{ $tarea['AnotacionesPosteriores'] ?: 'none' }}</p>
            <p><strong>Direccóon:</strong> {{ $tarea['Direccion'] }}</p>

        </div>

    <h4>Archivos adjuntos</h4>
    <div class="Data">
        <p><strong>Fichero resumen:</strong></p>
        @if ($resumenUrl)
            <p>Resumen: <a href="{{ $resumenUrl }}" target="_blank">Descargar</a></p>
        @else
            <p>No hay fichero resumen adjunto</p>
        @endif

        <p><strong>Fotos del trabajo Realizado posteriores:</strong></p>
        @if (count($fotosUrls) > 0)
            <div class="foto-container">
                @foreach ($fotosUrls as $fotoUrl)
                    <div class="foto-item">
                        <img src="{{ $fotoUrl }}" alt="Foto Trabajo Realizado">
                    </div>
                @endforeach
            </div>
        @else
            <p>No hay fotos del trabajo realizado adjuntas</p>
        @endif
    </div>
    </div>
    @if (auth()->user()->permiso == "operario" )

    <a href="{{ route('updTareas', [ 'id' => $tarea->IDTarea]) }}" class="btn btn-info">Actualizar tarea</a>
    @endif



    <a href="{{ route('listaTareas') }}" class="btn btn-primary">Volver a la lista de tareas</a>
@endsection
