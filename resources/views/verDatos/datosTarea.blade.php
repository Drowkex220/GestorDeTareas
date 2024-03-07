@extends('layout.plantilla')

@section('title', 'Detalles de Tarea')

@section('content')
    <style>
        .Data {
            border: solid;
            border-radius: 5px;
            border-width: 2px;
            padding: 20px;
            margin-bottom: 20px !important;
            border-color: rgb(179, 179, 179);
            padding-left: 10px
        }

        h4 {
            margin-bottom: 20px !important;
            color: #298df8;
        }
    </style>
    <h1>Detalles de la Tarea {{ $tarea['IDTarea'] }}</h1>
    @if (auth()->user()->permiso == 'operario')
        <a href="{{ route('updTareas', ['id' => $tarea->IDTarea]) }}" class="btn btn-info">Actualizar tarea</a>
    @endif

    <a href="{{ route('listaTareas') }}" class="btn btn-primary">Volver a la lista de tareas</a>
    <div class="tareaData" style="margin: 10px">
        <div class="Data row">
            <h4><strong>Detalles del contacto </strong></h4>

            <p class="col-6"><strong>NIF/CIF:</strong> {{ $tarea['NIF_CIF'] }}</p>
            <p class="col-6"><strong>Persona de contacto:</strong> {{ $tarea['PersonaContactoNombre'] }}
                {{ $tarea['PersonaContactoApellidos'] }}</p>
            <p class="col-6"><strong>Telefono de contacto:</strong> {{ $tarea['TelefonoContacto'] }}</p>
            <p class="col-6"><strong>Correo electronico:</strong> {{ $tarea['CorreoElectronico'] }}</p>
            <p class="col-6"><strong>Descripción:</strong> {{ $tarea['Descripcion'] }}</p>
        </div>

        <div class="Data row">
            <h4><strong>Ubicación</strong></h4>
            <p class="col-6"><strong>Dirección:</strong> {{ $tarea['Direccion'] }}</p>
            <p class="col-6"><strong>Población:</strong> {{ $tarea['Poblacion'] }}</p>
            <p class="col-6"><strong>Código Postal:</strong> {{ $tarea['CodigoPostal'] }}</p>
            <p class="col-6"><strong>ProvinciaCodigo:</strong> {{ $tarea['ProvinciaCodigo'] }}</p>
        </div>

        <div class="Data row">
            <h4><strong>Estado y fechas</strong> </h4>
            <p class="col-6"><strong>Estado:</strong> {{ $tarea['Estado'] }}</p>
            <p class="col-6"><strong>Fecha de creación:</strong> {{ $tarea['FechaCreacion'] }}</p>
            <p class="col-6"><strong>Fecha de realizacion:</strong> {{ $tarea['FechaRealizacion'] }}</p>
            <p class="col-6"><strong>Operario encargado:</strong> {{ $tarea['OperarioEncargado'] }}</p>
        </div>

        <div class="Data row">
            <h4><strong>Anotaciones</strong></h4>
            <p><strong>Anotaciones anteriores:</strong> {{ $tarea['AnotacionesAnteriores'] ?: 'none' }}</p>
            <p><strong>Anotaciones posteriores:</strong> {{ $tarea['AnotacionesPosteriores'] ?: 'none' }}</p>
        </div>

        <div class="Data row">
            <h4><strong>Archivos adjuntos</strong></h4>
            <p><strong>Fichero resumen:</strong></p>
            @if ($resumenUrl)
                <p>Resumen: <a href="{{ $resumenUrl }}" target="_blank">Descargar</a></p>
            @else
                <p>No hay fichero resumen adjunto</p>
            @endif
            <br>
            <br>
            <p><strong>Fotos del trabajo Realizado:</strong></p>
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
@endsection
