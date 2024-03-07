@extends('layout.plantilla')

@section('title', 'Formulario de Cuotas')

@section('content')
    <style>
        .datos {
            margin-bottom: 40px;
        }
        .formulario div{
            padding: 20px !important;
        }
    </style>
    <h1 class="mb-4">Formulario de Cuotas</h1>

    <form action="{{ route('saveCuota', ['modo' => $modo]) }}" method="POST" class="formulario  row">
        @csrf

        <h4>Datos de la cuota</h4>

        <input type="hidden" name="id" value="{{ old('id', isset($cuota) ? $cuota->id : '') }}">



        <div class="col-6"> <label for="cif">CIF</label>
            <input type="text" class="form-control" id="cif" name="cif" placeholder="CIF"
                value="{{ old('cif', isset($cuota) ? $cuota->cif : '') }}">

            @error('cif')
                <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror
        </div>
        <div class="col-6"><label for="concepto">Concepto</label>
            <input type="text" class="form-control" id="concepto" name="concepto" placeholder="Concepto"
                value="{{ old('concepto', isset($cuota) ? $cuota->concepto : '') }}">

            @error('concepto')
                <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror
        </div>
        <div class="col-6"><label for="fecha_emision">Fecha de emisión</label>
            <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" placeholder="dd/mm/yyyy"
                value="{{ old('fecha_emision', isset($cuota) ? $cuota->fecha_emision : '') }}">

            @error('fecha_emision')
                <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror
        </div>
        <div class="col-6"> <label for="importe">Importe</label>
            <input type="number" class="form-control" id="importe" name="importe" placeholder="importe €"
                value="{{ old('importe', isset($cuota) ? $cuota->importe : '') }}">

            @error('importe')
                <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror
        </div>
        <div class="col-6"> <label for="pagada">Pagada</label>
            <select class="form-control" id="pagada" name="pagada">
                <option value="1" {{ old('pagada', isset($cuota) ? $cuota->pagada : '') == '1' ? 'selected' : '' }}>
                    Sí</option>
                <option value="0" {{ old('pagada', isset($cuota) ? $cuota->pagada : '') == '0' ? 'selected' : '' }}>
                    No</option>
            </select>

            @error('pagada')
                <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror
        </div>

        <div class="col-6"><label for="fecha_pago">Fecha de pago</label>
            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" placeholder="dd/mm/yyyy"
                value="{{ old('fecha_pago', isset($cuota) ? $cuota->fecha_pago : '') }}">

            @error('fecha_pago')
                <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror
        </div>
        <div class="col-6"><label for="notas">Anotaciones</label>
            <input type="text" class="form-control" id="notas" name="notas" placeholder="Anotaciones..."
                value="{{ old('notas', isset($cuota) ? $cuota->notas : '') }}">

            @error('notas')
                <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}</div>
            @enderror
        </div>


        <h4>Relaciones</h4>
        <div class="row">


            <div class="col-6"><label for="id_tarea">Selecciona una tarea:</label>
                <select class="form-control" id="id_tarea" name="id_tarea" width="30%">
                    @foreach ($tareas as $tarea)
                        <option value="{{ $tarea->IDTarea }}">{{ $tarea->Descripcion }}</option>
                    @endforeach
                </select>

                @error('id_tarea')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>
            <div class="col-6"><label for="id_cliente">Selecciona un cliente:</label>
                <select class="form-control" id="id_cliente" name="id_cliente" width="30%">
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}: {{ $cliente->cif }}</option>
                    @endforeach
                </select>

                @error('id_cliente')
                    <div class="text-danger" style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}</div>
                @enderror
            </div>


        </div>










        <button type="submit" class="btn btn-primary">
            Guardar Cuota
        </button>
    </form>


@endsection
