@extends('layout.plantilla')

@section('title', 'Lista de Tareas')

@section('content')
    <h1>Listado de Cuotas</h1>

    @if (auth()->user()->permiso == 'admin')
        <a href="{{ route('addCuota') }}" class="btn btn-info"><i class="fa-solid fa-plus"></i> Añadir Cuota</a>
    @endif


    <form action="{{ route('resultadoFiltradoCuotas') }}" method="POST" class="formulario form form-control">
        @csrf
        <div class="form row">
            <div class="form-group col-6">
                <label for="campo">Campo:</label>
                <select class="form-control" id="campo" name="campo">
                    <option value="id">ID Cuota</option>
                    <option value="concepto">Concepto</option>
                    <option value="emision">Emisión</option>
                    <option value="importe">Importe</option>
                    <option value="pagada">Pagada</option>
                    <option value="fecha_pago">Fecha de Pago</option>
                    <option value="notas">Notas</option>
                    <option value="id_cliente">CIF Cliente</option>
                    <option value="id_tarea">Tarea</option>
                </select>

            </div>
            <div class="form-group col-6">
                <label for="termino">Término de búsqueda:</label>
                <input type="text" class="form-control" id="termino" name="termino">
            </div>
        </div>
        <button type="submit" class="btn btn-primary col-12">Filtrar</button>
    </form>
    <table >
        <thead >
            <tr>
                <th>ID cuota</th>
                <th>Concepto</th>
                <th>Emisión</th>
                <th>Importe</th>
                <th>Pagada</th>
                <th>Fecha de pago</th>
                <th>Notas</th>
                <th>CIF Cliente</th>
                <th>Tarea</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($cuotas as $cuota)
                <tr>
                    <td>#{{ $cuota->id }}</td>
                    <td>{{ $cuota->concepto }}</td>
                    <td>{{ $cuota->fecha_emision }}</td>
                    <td>{{ $cuota->importe }}</td>
                    <td>@if ($cuota->pagada == 1)
                        pagada
                        @else
                        sin pagar
                        @endif</td>
                    <td>{{ $cuota->fecha_pago }}</td>
                    <td>{{ $cuota->notas }}</td>
                    <td>{{ $cuota->cliente->cif }}</td>
                    @if ($cuota->id_tarea)
                        <td>{{ $cuota->tarea->Descripcion }}</td>
                    @else
                        <td>No hay tarea asignada</td>
                    @endif

                    <td>

                        <a href="{{ route('modCuota', ['id' => $cuota->id]) }}" class=""><i
                                class="fa fa-edit fa-lg"></i></a>
                        <a href="{{ route('formDeleteCuota', ['id' => $cuota->id]) }}" class=""><i
                                class="fa fa-trash fa-lg"></i></a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $cuotas->links() }}
@endsection
