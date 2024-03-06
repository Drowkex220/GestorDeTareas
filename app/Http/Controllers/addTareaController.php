<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\tareaRequest;
use App\Http\Requests\updateTareaRequest;

use App\Models\Usuario;
use App\Models\Provincia;
use App\Models\Tarea;


class addTareaController extends Controller
{

    public function __invoke()
    {

        $modo = "add";
        $operarios = (new Usuario())->obtenerOperarios();
        $provincias = Provincia::all();


        return view('gestion_tareas/add_tarea', compact(["modo", "operarios", "provincias"]));
    }


    public function saveTarea(tareaRequest $request, $modo)
    {
        $datosTarea = $request->validated();

        if ($modo == "mod") {
            //echo("\nactualizando tarea #".$request->IDTarea);

            $tarea = (new Tarea())->actualizarTarea($request->IDTarea, $request);

            return redirect()->route('listaTareas');
        } else if ($modo == "add") {

            $tarea = (new Tarea())->guardarTarea($request);
            return redirect()->route('listaTareas');
        }
    }

    public function modTarea($id)
    {


        $modo = "mod";
        $tarea = (new Tarea())->obtenerTareaPorId($id);
        $operarios = (new Usuario())->obtenerOperarios();
        $provincias = Provincia::all();


        return view('gestion_tareas/add_tarea', compact(["modo", "tarea", "operarios", "provincias"]));
    }


    public function formDeleteTarea($id)
    {
        $tarea = Tarea::find($id);

        return view('gestion_tareas/delete_form_tarea', compact(["tarea"]));
    }

    public function deleteTarea($id)
    {

        echo ($id);

        $tarea = Tarea::find($id);

        $tarea->delete();

        $mensaje = urlencode("Tarea # " . $tarea->IDTarea . " " . $tarea->Descripcion . " borrada correctamente");


        return redirect()->route('resultadoDelete', ['message' => $mensaje, 'route' => "listaTareas"]);
    }

    public function resultadoDelete($message, $route)
    {

        $mensaje = urldecode($message);
        $route = urldecode($route);
        return view('compartido/resultado_delete', compact(["mensaje", "route"]));
    }

    public function updForm($id) {
        if(auth()->user()->permiso == "operario" ){
            $tarea = Tarea::find($id);

            return view('gestion_tareas/update_tarea', compact(["tarea"]));
        } else{
            return redirect()->route('listaTareas');
        }



    }

    public function saveUpdateTareas(updateTareaRequest $request){
        $datosTarea = $request->validated();
        print_r($request->IDTarea);

        $tarea = (new Tarea())->updateTarea($request->IDTarea, $request);

        return redirect()->route('detallesTarea', ['id' => $request->IDTarea]);
    }

}
