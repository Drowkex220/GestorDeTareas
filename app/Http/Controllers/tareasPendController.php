<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tarea;

/**
 * Controlador para mostrar las tareas pendientes.
 */
class tareasPendController extends Controller
{
    //
    /**
     * Muestra las tareas pendientes.
     *
     * Si el usuario autenticado tiene permiso de "operario", muestra las tareas pendientes asignadas a ese operario.
     * Si el usuario autenticado no es un "operario", muestra todas las tareas pendientes.
     *
     * @return \Illuminate\View\View Vista que muestra las tareas pendientes.
     */
    public function __invoke()
    {
        $user = auth()->user();
        $tareas = [];

        if (isset($user) && $user->permiso == "operario") {
            // Obtener el ID del operario actual
            $operarioId = $user->id;

            // Seleccionar todas las tareas con estado "P" y operario igual al ID del operario actual
            $tareas = Tarea::where('Estado', 'P')
                ->where('OperarioEncargado', $operarioId)
                ->get();
        } else {
            // Si el permiso no es "operario", seleccionar todas las tareas pendientes
            $tareas = (new Tarea())->obtenerTareasPendientes();
        }

        // Pasar los datos a la vista
        return view('listas/tareasPendientes', ['tareas' => $tareas]);
    }
}
