<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Tarea;


class indexController extends Controller
{
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
