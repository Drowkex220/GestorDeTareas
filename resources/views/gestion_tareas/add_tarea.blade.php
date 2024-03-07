@extends('layout.plantilla')

@section('title', 'Formulario')

@section('content')
    <style>
        input.form-control {
            width: 300px;
            /* Puedes ajustar el ancho según tus necesidades */
            margin-bottom: 10px;
            /* Añade un margen inferior para separar los campos */
        }

        textarea.form-control {
            width: 300px;
            /* Puedes ajustar el ancho según tus necesidades */
            height: 100px;
            /* Puedes ajustar la altura según tus necesidades */
            margin-bottom: 10px;
            /* Añade un margen inferior para separar los campos */
        }

        .error {
            color: red;
        }
    </style>
    <h1 class="mb-4">Formulario de Tareas</h1>


    <form action="{{ route('saveTareas', ['modo' => $modo]) }}" method="POST" class="formulario form form-control">
        @csrf <!-- Agregar este campo para el token CSRF -->



        <h4>Datos de tarea</h4>
        <input type="hidden" name="IDTarea" value="{{ old('IDTarea', isset($tarea) ? $tarea->IDTarea : '') }}">

        <div class="datos row">
            <div class="col-6">
                <label for="nif_cif">NIF/CIF</label>
                <input type="text" class="form-control" id="NIF_CIF" name="NIF_CIF" placeholder="NIF/CIF"
                    value="{{ old('NIF_CIF', isset($tarea) ? $tarea->NIF_CIF : '') }}">

                @error('NIF_CIF')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">

                @auth
                    <label for="OperarioEncargado">Operario Encargado</label>
                    <select class="form-control" id="OperarioEncargado" name="OperarioEncargado">
                        @foreach ($operarios as $operario)
                            <option value="{{ $operario['id'] }}"
                                {{ old('OperarioEncargado', isset($tarea) && $tarea->OperarioEncargado == $operario['id'] ? 'selected' : '') }}>
                                {{ $operario['nombre_usuario'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('OperarioEncargado')
                        <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            {{ $message }}</div>
                    @enderror
                @endauth


                @guest
                    <input type="hidden" name="OperarioEncargado" value="">

                @endguest

            </div>

            <div class="col-6">
                <label for="Descripcion">Descripción</label>
                <textarea class="form-control" id="Descripcion" name="Descripcion" placeholder="Descripción">{{ old('Descripcion', isset($tarea) ? $tarea->Descripcion : '') }}</textarea>

                @error('Descripcion')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <label for="FechaCreacion">Fecha de creación</label>
                <input type="date" class="form-control" id="FechaCreacion" name="FechaCreacion"
                    placeholder="Fecha de creacion"
                    value="{{ old('FechaCreacion', isset($tarea) ? $tarea->FechaCreacion : '') }}">

                @error('FechaCreacion')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>




        </div>


        <h4>Datos de contacto</h4>
        <div class="datos row">
            <div class="col-6">
                <label for="PersonaContactoNombre">Nombre de persona de contacto</label>
                <input type="text" class="form-control" id="PersonaContactoNombre" name="PersonaContactoNombre"
                    placeholder="Nombre de persona de contacto"
                    value="{{ old('PersonaContactoNombre', isset($tarea) ? $tarea->PersonaContactoNombre : '') }}">

                @error('PersonaContactoNombre')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <label for="PersonaContactoApellidos">Apellidos de persona de contacto</label>
                <input type="text" class="form-control" id="PersonaContactoApellidos" name="PersonaContactoApellidos"
                    placeholder="Apellidos de persona de contacto"
                    value="{{ old('PersonaContactoApellidos', isset($tarea) ? $tarea->PersonaContactoApellidos : '') }}">

                @error('PersonaContactoApellidos')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <label for="TelefonoContacto">Teléfono de contacto</label>
                <input type="tel" class="form-control" id="TelefonoContacto" name="TelefonoContacto"
                    placeholder="Teléfono"
                    value="{{ old('TelefonoContacto', isset($tarea) ? $tarea->TelefonoContacto : '') }}">

                @error('TelefonoContacto')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <label for="CorreoElectronico">Correo Electrónico</label>
                <input type="email" class="form-control" id="CorreoElectronico" name="CorreoElectronico"
                    placeholder="Correo Electrónico"
                    value="{{ old('CorreoElectronico', isset($tarea) ? $tarea->CorreoElectronico : '') }}">

                @error('CorreoElectronico')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>
        </div>

        <h4>Datos de ubicación</h4>
        <div class="datos row">
            <div class="col-6">
                <label for="Provincia">Provincia</label>
                <select class="form-control" id="Provincia" name="Provincia" width="30">
                    @foreach ($provincias as $provincia)
                        <option value="{{ $provincia['codigo_ine'] }}"
                            {{ old('Provincia', isset($tarea) && $tarea->Provincia == $provincia['codigo_ine'] ? 'selected' : '') }}>
                            {{ $provincia['nombre'] }}
                        </option>
                    @endforeach
                </select>
                @error('Provincia')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>


            <div class="col-6">
                <label for="Poblacion">Población</label>
                <input type="text" class="form-control" id="Poblacion" name="Poblacion" placeholder="Población"
                    value="{{ old('Poblacion', isset($tarea) ? $tarea->Poblacion : '') }}">

                @error('Poblacion')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>


            <div class="col-6">
                <label for="Direccion">Dirección</label>
                <input type="text" class="form-control" id="Direccion" name="Direccion" placeholder="Dirección"
                    value="{{ old('Direccion', isset($tarea) ? $tarea->Direccion : '') }}">

                @error('Direccion')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>



            <div class="col-6">
                <label for="CodigoPostal">Código Postal</label>
                <input type="number" class="form-control" id="CodigoPostal" name="CodigoPostal"
                    placeholder="Código Postal"
                    value="{{ old('CodigoPostal', isset($tarea) ? $tarea->CodigoPostal : '') }}">

                @error('CodigoPostal')
                    <div class="text-danger" style="color:red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>
        </div>




        <button type="submit" class="btn btn-primary col-12">
            Guardar Tarea
        </button>
    </form>
@endsection
