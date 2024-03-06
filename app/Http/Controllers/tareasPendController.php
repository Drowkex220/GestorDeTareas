<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tarea;

class tareasPendController extends Controller
{
    //

    public function __invoke(){
        $user = auth()->user();
        $tareas = [];

        if ( isset($user) && $user->permiso == "operario") {
            // Obtener el ID del operario actual
            $operarioId = $user->id;
            echo"id: ".($user->id);
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
