@extends('layout.plantilla')

@section('title', 'Formulario de clientes')

@section('content')
    <style>
        .datos {
            margin-bottom: 40px
        }

        .formulario div{
            padding: 20px !important;
        }
    </style>
    <h1 class="mb-4">Formulario de Clientes</h1>

    <form action="{{ route('saveCliente', ['modo' => $modo]) }}" method="POST" class="formulario form form-control">
        @csrf

        <h4>Datos personales</h4>
        <input type="hidden" name="id" value="{{ old('id', isset($cliente) ? $cliente->id : '') }}">


        <div class="datos row">
            <div class="col-6">
                <label for="cif">CIF</label>
                <input type="text" class="form-control" id="cif" name="cif" placeholder="CIF"
                    value="{{ old('cif', isset($cliente) ? $cliente->cif : '') }}">

                @error('cif')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror

            </div>

            <div class="col-6">

                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre"
                    value="{{ old('nombre', isset($cliente) ? $cliente->nombre : '') }}">

                @error('nombre')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">

                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono"
                    value="{{ old('telefono', isset($cliente) ? $cliente->telefono : '') }}">

                @error('telefono')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <label for="correo">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="correo@gmail.com"
                    value="{{ old('correo', isset($cliente) ? $cliente->correo : '') }}">

                @error('correo')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror

            </div>



        </div>



        <h4>Datos para el pago</h4>
        <div class="datos row">
            <div class="col-6">

                <label for="cuenta_corriente">Cuenta Corriente</label>
                <input type="text" class="form-control" id="cuenta_corriente" name="cuenta_corriente"
                    placeholder="ID de cuenta corriente"
                    value="{{ old('cuenta_corriente', isset($cliente) ? $cliente->cuenta_corriente : '') }}">

                @error('cuenta_corriente')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>


            <div class="col-6">

                <label for="pais">País</label>
                <input type="text" class="form-control" id="pais" name="pais" placeholder="País de residencia"
                    value="{{ old('pais', isset($cliente) ? $cliente->pais : '') }}">

                @error('pais')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <label for="moneda">Moneda</label>
                <select class="form-control" id="moneda" name="moneda">
                    <option value="">Seleccionar Moneda</option>
                    @foreach ($currencies2 as $key => $value)
                        @if ($value)
                            <option value="{{ $key }}"
                                {{ old('moneda', isset($cliente) && $cliente->moneda == $key ? 'selected' : '') }}>
                                {{ $value }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('moneda')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror

            </div>


            <div class="col-6">

                <label for="importe_c_mensual">Importe mensual en €</label>
                <input type="number" class="form-control" id="importe_c_mensual" name="importe_c_mensual"
                    placeholder="Importe de cliente mensual"
                    value="{{ old('importe_c_mensual', isset($cliente) ? $cliente->importe_c_mensual : '') }}">

                @error('importe_c_mensual')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="row">
            <button type="submit" class="btn btn-primary col-12">
                Guardar cliente
            </button>
        </div>

    </form>


@endsection
