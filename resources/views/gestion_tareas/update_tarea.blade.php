@extends('layout.plantilla')

@section('title', 'Actualizar Tarea')

@section('content')

    <h1>Actualizar Tarea</h1>

    <div class="Data formulario ">
        Persona de contacto: {{ $tarea->PersonaContactoNombre }} {{ $tarea->PersonaContactoApellidos }}
        <p>Descripcion: {{ $tarea->Descripcion }}</p>
        <p>Telefono de contacto: {{ $tarea->TelefonoContacto }}</p>
        <p>Estado: {{ $tarea->Estado }}</p>
        <p>Fecha de creacion: {{ $tarea->FechaCreacion }}</p>

    </div>

    <form action="{{ route('saveUpdTareas') }}" method="POST" enctype="multipart/form-data" class="formulario Data form form-control">
        @csrf
        <div>

            @dump($tarea)
            <h4>ID</h4>
            <input type="text" name="IDTarea" value="{{ $tarea->IDTarea }}">

            <label>Estado:</label>
            <div>
                <label for="estado_B" class="btn btn-info">B</label>
                <input type="radio" id="estado_B" name="Estado" value="B"
                    @if (isset($tarea) && $tarea->Estado == 'B') checked @endif>

                <label for="estado_P"class="btn btn-warning">P</label>
                <input type="radio" id="estado_P" name="Estado" value="P"
                    @if (isset($tarea) && $tarea->Estado == 'P') checked @endif>

                <label for="estado_R"class="btn btn-danger">R</label>
                <input type="radio" id="estado_R" name="Estado" value="R"
                    @if (isset($tarea) && $tarea->Estado == 'R') checked @endif>

                <label for="estado_C"class="btn btn-success">C</label>
                <input type="radio" id="estado_C" name="Estado" value="C"
                    @if (isset($tarea) && $tarea->Estado == 'C') checked @endif>
            </div>

            @error('Estado')
                <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror
        </div>



        <div>
            <label for="FechaRealizacion">Fecha de realización:</label>
            <input type="date" class="form-control" id="FechaRealizacion" name="FechaRealizacion"
                placeholder="Fecha de realizacion" required
                @if (isset($tarea)) value="{{ $tarea->FechaRealizacion }}" @endif>

            @error('FechaRealizacion')
                <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror
        </div>


        <div class="">
            <div>
                <label for="AnotacionesAnteriores">Anotaciones Anteriores:</label>
                <textarea class="form-control" id="AnotacionesAnteriores" name="AnotacionesAnteriores"
                    placeholder="Anotaciones Anteriores">{{ $tarea->AnotacionesAnteriores }}</textarea>



                @error('AnotacionesAnteriores')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror

            </div>

            <div>
                <label for="AnotacionesPosteriores">Anotaciones Posteriores:</label>
                <textarea class="form-control" id="AnotacionesPosteriores" name="AnotacionesPosteriores"
                    placeholder="Anotaciones Posteriores">{{ $tarea->AnotacionesPosteriores }}</textarea>

                @error('AnotacionesPosteriores')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="FicheroResumen">Fichero Resumen:</label>
                @if (isset($tarea->FicheroResumen) && !empty($tarea->FicheroResumen))
                    <p>Resumen: <a href="{{ asset($tarea->FicheroResumen) }}" target="_blank">Descargar</a></p>
                @endif
                <input type="file" class="form-control" id="FicheroResumen" name="FicheroResumen"
                    placeholder="Fichero Resumen">

                @error('FicheroResumen')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>


            <div>
                <label for="FotosTrabajoRealizado">Fotos Trabajo Realizado:</label>
                <input type="file" class="form-control" id="FotosTrabajoRealizado" name="FotosTrabajoRealizado[]"
                    multiple>
                <small>Seleccione múltiples archivos manteniendo presionada la tecla Ctrl (o Command en Mac).</small>

                @error('FotosTrabajoRealizado')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div>
                <label hidden for="fotos_trabajo_realizado_actual">Fotos Trabajo Realizado Actual:</label>
                <input hidden type="text" class="form-control" id="fotos_trabajo_realizado_actual"
                    name="fotos_trabajo_realizado_actual" placeholder="Fotos Trabajo Realizado"
                    @if (isset($tarea)) value="{{ $tarea->FotosTrabajoRealizado }}" @endif>
            </div>

            @if (isset($tarea->fotos_trabajo_realizado))
                <div class="foto-container">
                    @foreach (explode(',', $tarea->FotosTrabajoRealizado) as $rutaFoto)
                        @if ($rutaFoto != '')
                            @php
                                $nombreFoto = pathinfo($rutaFoto)->filename;
                            @endphp
                            <div class="foto-item">
                                <img src="{{ asset($rutaFoto) }}" alt="Foto Trabajo Realizado">
                                <p>{{ $nombreFoto }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>


            <button type="submit" class="btn btn-primary">Actualizar</button>

    </form>
@endsection
