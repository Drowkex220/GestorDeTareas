@extends('layout.plantilla')

@section('title', 'Lista de clientes')

@section('content')
    <h1>Listado de clientes</h1>

    <a href="{{ route('addCliente') }}" class="btn btn-info"><i class="fa-solid fa-plus"></i> Añadir Cliente</a>

    <table class="">
        <thead class="">
            <tr>
                <th>ID cliente</th>
                <th>CIF</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Cuenta corriente</th>
                <th>País</th>
                <th>moneda</th>
                <th>Importe mensual</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->cif }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->correo }}</td>
                    <td>{{ $cliente->cuenta_corriente }}</td>
                    <td>{{ $cliente->pais }}</td>
                    <td>{{ $cliente->moneda }}</td>
                    <td>{{ $cliente->importe_c_mensual }}€</td>
                    <td>

                        <a href="{{ route('modCliente', ['id' => $cliente->id]) }}" class=""><i
                                class="fa fa-edit fa-lg"></i></a>
                        <a href="{{ route('formDeleteCliente', ['id' => $cliente->id]) }}" class=""><i
                                class="fa fa-trash fa-lg"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $clientes->links() }}
@endsection
