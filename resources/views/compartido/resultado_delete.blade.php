@extends("layout.plantilla")

@section('title', 'Tarea borrada')

@section('content')
<h2>{{ $mensaje }} </h2>
<a href="{{ route($route) }}" class="btn btn-primary">Volver a la lista</a>

@endsection
