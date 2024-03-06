<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/plantilla.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    @yield('Lista de Tareas')

    <!--favicon-->
    <!--estilos-->

</head>

<body class="">
    <!--header-->
    <header class="row">
        <h4 id="main_title" class="col-2"><strong>
                <i class="fa fa-elevator fa-xl" aria-hidden="true"></i>
                NOSECAEN</h4></strong>
        @auth
            <div class="col-5 nav-h">
                <a href={{ url('listaTareas') }}><i class="fa fa-briefcase" aria-hidden="true"></i>Tareas</a>

                @if (auth()->user()->permiso == 'admin')

                    <a href={{ url('listaCuotas') }}><i class="fa fa-file" aria-hidden="true"></i> Cuotas</a>

                    <a href={{ url('listaClientes') }}><i class="fa fa-user-group" aria-hidden="true"></i>
                        Clientes</a>


                    <a href={{ url('listaUsuarios') }}><i class="fa fa-users" aria-hidden="true"></i>
                        Usuarios</a>

                @endauth
        </div>

        <div class=" user-data col-3">
            <p><strong>Nombre de Usuario:</strong> {{ auth()->user()->nombre_usuario }} | <strong>Permiso:</strong>
                {{ auth()->user()->permiso }}</p>

            <p><strong>Ultima sesión:</strong> {{ auth()->user()->last_sesion }}</p>
        </div>

        <div class="col-1 login-options">

            <a href="{{ route('modUsuario', ['id' => auth()->user()->id]) }}" class="btn btn-warning options"><i
                    class="fa fa-gear"></i></a>

            <a href={{ route('logout') }} class="btn btn-danger logout"><i class="fa fa-right-from-bracket "
                    aria-hidden="true"></i></a>
        </div>

    @endauth

    @guest
        <div class="col-5"></div>
        <p class="col-2">No estas autenticado</p>
        <div class="col-1">
            <a href={{ route('loginForm') }} class="btn btn-info"><i class="fa fa-user" aria-hidden="true"></i> Log
                in</a>
        </div>

    @endguest

</header>

<!--nav-->

<div id="main_container" class="row">
    <nav class="nav-1 col-2">

        <a href={{ route('index') }}><i class="fa fa-home" aria-hidden="true"></i> Inicio</a>
        @auth
            <a href={{ route('tareasPend') }}><i class="fa fa-file-excel" aria-hidden="true"></i> Tareas
                    Pendientes</a></li>

            <a href={{ url('listaTareas') }}><i class="fa fa-briefcase" aria-hidden="true"></i> Lista de Tareas</a>

            @if (auth()->user()->permiso == 'admin')
                <a href={{ url('listaCuotas') }}><i class="fa fa-file" aria-hidden="true"></i> Lista de Cuotas</a>

                <a href={{ url('listaClientes') }}><i class="fa fa-user-group" aria-hidden="true"></i> Lista de
                        Clientes</a>

                <a href={{ url('listaUsuarios') }}><i class="fa fa-users" aria-hidden="true"></i> Lista de
                        Usuarios</a>
            @endif



        @endauth
        @guest
            <a href={{ url('authCliente') }}><i class="fa fa-document" aria-hidden="true"></i> Proponer Tarea</a>

            @endguest



    </nav>

    <div id="content" class="content col-10">
        @yield('content')
    </div>
</div>


<footer>
    <p>NOSECAE</p>
    <br>

    <p>Julián Arias Mora</p>
    <br>
    <p>2024©</p>
</footer>


</body>

</html>
