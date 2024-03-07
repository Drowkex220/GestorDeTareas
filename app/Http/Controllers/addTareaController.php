<?php
/**
 * Controlador para la gestión de tareas.
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\tareaRequest;
use App\Http\Requests\updateTareaRequest;

use App\Models\Usuario;
use App\Models\Provincia;
use App\Models\Tarea;


class addTareaController extends Controller
{


    /**
     * Muestra el formulario para añadir una nueva tarea.
     *
     * @return \Illuminate\View\View Vista con el formulario de añadir tarea.
     */
    public function __invoke()
    {

        $modo = "add";
        $operarios = (new Usuario())->obtenerOperarios();
        $provincias = Provincia::all();


        return view('gestion_tareas/add_tarea', compact(["modo", "operarios", "provincias"]));
    }

    /**
     * Guarda una nueva tarea o actualiza una existente.
     *
     * @param tareaRequest $request     Datos de la tarea.
     * @param string       $modo        Modo de operación ('add' para añadir, 'mod' para modificar).
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de tareas.
     */
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
    /**
     * Muestra el formulario para modificar una tarea existente.
     *
     * @param int $id     ID de la tarea a modificar.
     * @return \Illuminate\View\View Vista con el formulario de modificar tarea.
     */
    public function modTarea($id)
    {


        $modo = "mod";
        $tarea = (new Tarea())->obtenerTareaPorId($id);
        $operarios = (new Usuario())->obtenerOperarios();
        $provincias = Provincia::all();


        return view('gestion_tareas/add_tarea', compact(["modo", "tarea", "operarios", "provincias"]));
    }

    /**
     * Muestra el formulario de confirmación para borrar una tarea.
     *
     * @param int $id     ID de la tarea a borrar.
     * @return \Illuminate\View\View Vista con el formulario de confirmación para borrar tarea.
     */
    public function formDeleteTarea($id)
    {
        $tarea = Tarea::find($id);

        return view('gestion_tareas/delete_form_tarea', compact(["tarea"]));
    }
    /**
     * Borra una tarea existente.
     *
     * @param int $id     ID de la tarea a borrar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de tareas con mensaje de confirmación.
     */
    public function deleteTarea($id)
    {

        echo ($id);

        $tarea = Tarea::find($id);

        $tarea->delete();

        $mensaje = urlencode("Tarea # " . $tarea->IDTarea . " " . $tarea->Descripcion . " borrada correctamente");


        return redirect()->route('resultadoDelete', ['message' => $mensaje, 'route' => "listaTareas"]);
    }
    /**
     * Muestra el formulario para actualizar una tarea existente.
     *
     * @param int $id     ID de la tarea a actualizar.
     * @return \Illuminate\View\View Vista con el formulario de actualizar tarea.
     */
    public function resultadoDelete($message, $route)
    {

        $mensaje = urldecode($message);
        $route = urldecode($route);
        return view('compartido/resultado_delete', compact(["mensaje", "route"]));
    }
    /**
     * Guarda los cambios de la tarea actualizada.
     *
     * @param updateTareaRequest $request     Datos actualizados de la tarea.
     * @return \Illuminate\Http\RedirectResponse Redirección a los detalles de la tarea actualizada.
     */
    public function updForm($id)
    {
        if (auth()->user()->permiso == "operario") {
            $tarea = Tarea::find($id);

            return view('gestion_tareas/update_tarea', compact(["tarea"]));
        } else {
            return redirect()->route('listaTareas');
        }
    }

    public function saveUpdateTareas(updateTareaRequest $request)
    {
        $datosTarea = $request->validated();
        print_r($request->IDTarea);

        $tarea = (new Tarea())->updateTarea($request->IDTarea, $request);

        return redirect()->route('detallesTarea', ['id' => $request->IDTarea]);
    }
}
