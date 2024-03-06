<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cuota;
use App\Models\Tarea;

class listasController extends Controller
{

    public function listaTareasVue() {
        $user = auth()->user();
        $tareas = [];


            // Si el permiso no es "operario", seleccionar solo dos tareas
            $tareas = Tarea::take(2)->get();


        // Pasar los datos a la vista
        return view('listas/tareas_vue', ['tareas' => $tareas]);
    }


    public function listaTareas()
{
    $user = auth()->user();
    $tareas = [];

    if ($user->permiso == "operario") {
        // Obtener el ID del operario actual
        $operarioId = $user->id;

        // Seleccionar todas las tareas con operario encargado igual al ID del operario actual y paginar los resultados
        $tareas = Tarea::where('OperarioEncargado', $operarioId)->paginate(5);
    } else {
        // Si el permiso no es "operario", seleccionar todas las tareas y paginar los resultados
        $tareas = Tarea::paginate(5);
    }

    // Pasar los datos a la vista
    return view('listas/tareas', ['tareas' => $tareas]);
}


    public function listaClientes()
    {
        $clientes = Cliente::paginate(5);        // Pasar los datos a la vista
        return view('listas/clientes', ['clientes' => $clientes]);
    }

    public function listaCuotas()
    {
        // Obtener todas las cuotas paginadas
        $cuotas = Cuota::paginate(5);

        // Crear un array para almacenar las descripciones de las tareas
        $descripciones = [];

        // Obtener las descripciones de las tareas para cada cuota
        foreach ($cuotas as $cuota) {
            // Buscar la tarea asociada a la cuota y obtener su descripción
            $tarea = Tarea::find($cuota->id_tarea);

            // Si se encuentra la tarea, almacenar su descripción; de lo contrario, almacenar un mensaje indicando que la tarea no se encontró
            $descripcion = $tarea ? $tarea->Descripcion : 'Tarea no encontrada';

            // Almacenar la descripción en el array
            $descripciones[$cuota->id_cuota] = $descripcion;


            $cliente = Cliente::find($cuota->id_cliente);

            // Si se encuentra el cliente, almacenar su CIF; de lo contrario, almacenar un mensaje indicando que el cliente no se encontró
            $cif = $cliente ? $cliente->cif : 'Cliente no encontrado';

            // Almacenar el CIF en el array
            $cifs[$cuota->id_cuota] = $cif;
        }



        // Pasar los datos a la vista
        return view('listas/cuotas', [
            'cuotas' => $cuotas,
            'descripciones' => $descripciones,
            'cifs' =>$cifs
        ]);
    }

    public function listaUsuarios()
    {
        $usuarios = Usuario::paginate(10);        // Pasar los datos a la vista
        return view('listas/usuarios', ['usuarios' => $usuarios]);
    }


    public function filtrarTareas() {
        $user = auth()->user();
        $tareas = [];

        if ($user->permiso == "operario") {
            // Obtener el ID del operario actual
            $operarioId = $user->id;

            // Seleccionar todas las tareas con operario encargado igual al ID del operario actual y paginar los resultados
            $tareas = Tarea::where('OperarioEncargado', $operarioId)->paginate(5);
        } else {

            // Si el permiso no es "operario", seleccionar todas las tareas y paginar los resultados
            $tareas = Tarea::paginate(10);
        }

        // Pasar los datos a la vista
        return view('listas/filter_tareas', ['tareas' => $tareas]);
    }

    public function resultadoFiltrado (Request $request) {

        $campo = $request->input('campo');
        $termino = $request->input('termino');

        $tareas = Tarea::query();

        if ($campo && $termino) {
            $tareas->where($campo, 'like', '%' . $termino . '%');
        } else {

            return redirect()->route('listaTareas');
        }

        $tareas = $tareas->paginate(10);

        return view('listas/tareas', ['tareas' => $tareas]);
    }
}
