@extends("layout.plantilla")

@section('title', 'Tareas Pendientes')

@section('content')

        <h1 style="margin-bottom: 65px !important"> Tareas Pendientes</h1>

        <table class="">
            <thead class="">
                <tr>
                    <th scope="col">CIF</th>
                    <th scope="col">Persona de contacto</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Teléfono </th>
                    <th scope="col">Estado</th>
                    <th scope="col">Operario</th>
                    <th scope="col">Creación</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tareas as $tarea)

                    <tr>
                        <th scope="row">{{ $tarea['NIF_CIF'] }}</th>
                        <td>{{ $tarea['PersonaContactoNombre'] }} {{ $tarea['PersonaContactoApellidos'] }}</td>
                        <td>{{ $tarea['Descripcion'] }}</td>
                        <td>{{ $tarea['TelefonoContacto'] }}</td>
                        <td>{{ $tarea['Estado'] }}</td>
                        <td>{{ $tarea['OperarioEncargado'] }}</td>
                        <td>{{ $tarea['FechaCreacion'] }}</td>
                        <td>
                            <a href="{{ route('detallesTarea', ['id' => $tarea['IDTarea']]) }}" class="info"><i class="fa fa-eye fa-lg info"></i></a>
                            <a href="{{ route('modTareas', ['id' => $tarea['IDTarea']]) }}" class="warning"><i class="fa fa-edit fa-lg warning"></i></a>
                            <a href="{{ route('formDeleteTarea', ['id' => $tarea->IDTarea]) }}" class="danger"><i class="fa fa-trash fa-lg"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .btn {
            text-decoration: none;
        }

        #page {
            margin: 1%;
        }

    </style>
@endsection
