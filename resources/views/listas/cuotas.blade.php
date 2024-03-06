@extends('layout.plantilla')

@section('title', 'Lista de cuotas')

@section('content')
    <h1>Listado de cuotas</h1>

    <div class="list-btn">
        <a href="{{ route('addCuota') }}" class="btn btn-info"><i class="fa-solid fa-plus"></i> Añadir Cuota</a>

        <a href="{{ route('cuotaMensual') }}" class="btn float-right btn-success cuota-btn"><i class="fa-solid fa-calendar"></i>Cuota Mensual</a>
    </div>

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
