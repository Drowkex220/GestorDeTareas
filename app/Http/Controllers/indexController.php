<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Tarea;


/**
 * Controlador para la página de inicio.
 */
class indexController extends Controller
{
      /**
     * Muestra la página de inicio con datos de las tareas.
     *
     * @return \Illuminate\View\View  Vista de la página de inicio.
     */
    public function index()
    {
        // Obtener todos los clientes
        /*$clientes = Cliente::all();

        $clientes = Cliente::where('importe_c_mensual', '>', 10)->get();
        $clientes = (new Cliente())->clientesConImporteMayorA10();*/
        $tareas = (new Tarea())->obtenerTodasLasTareas();
        // Pasar los datos a la vista
        return view('index', ['tareas' => $tareas]);
    }
}
