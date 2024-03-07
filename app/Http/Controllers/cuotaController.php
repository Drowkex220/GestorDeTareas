<?php

namespace App\Http\Controllers;

use App\Mail\correoMensual;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\cuotaRequest;
use App\Models\Cuota;
use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\Tarea;

use App\Models\Usuario;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de cuotas.
 */
class cuotaController extends Controller
{
    /**
     * Muestra el formulario para agregar una nueva cuota.
     *
     * @return \Illuminate\View\View Vista con el formulario para agregar una cuota.
     */
    public function cuotaForm()
    {
        $modo = "add";
        $cuotas = Cuota::all();
        $tareas = Tarea::all();
        $clientes = Cliente::all();


        return view("gestion_cuotas/form_cuota", compact("cuotas", "tareas", "clientes", "modo"));
    }
    /**
     * Guarda una cuota nueva o actualizada en la base de datos.
     *
     * @param  \App\Http\Requests\cuotaRequest  $request   Datos de la cuota provenientes del formulario.
     * @param  string  $modo                              Modo de operación ('add' para agregar, 'mod' para modificar).
     * @return \Illuminate\View\View       Redirige a la lista de cuotas después de guardar.
     */
    public function saveCuota(cuotaRequest $request, $modo)
    {
        $datosCuota = $request->validated();
        //echo ($request->id);


        if ($modo == "mod") {


            $cuota = (new Cuota())->actualizarCuota($request->id, $request);

            echo ("Modificado");
            return redirect()->route('listaCuotas');
        } else if ($modo == "add") {

            $cuota = (new Cuota())->guardarCuota($request);

            echo ("Añadido");
            return redirect()->route('listaCuotas');
        }


        return view("gestion_cuotas/save_cuota");
    }
    /**
     * Muestra el formulario para modificar una cuota existente.
     *
     * @param  int  $id  ID de la cuota a modificar.
     * @return \Illuminate\View\View       Vista con el formulario para modificar una cuota.
     */
    public function modCuota($id)
    {
        $modo = "mod";
        $cuota = Cuota::find($id);
        $cuotas = Cuota::all();
        $tareas = Tarea::all();
        $clientes = Cliente::all();

        echo ("modo modificar");
        return view("gestion_cuotas/form_cuota", compact("modo", "cuota", "cuotas", "tareas", "clientes"));
    }
    /**
     * Muestra el formulario para eliminar una cuota.
     *
     * @param  int  $id  ID de la cuota a eliminar.
     * @return \Illuminate\View\View       Vista con el formulario para eliminar una cuota.
     */
    public function formDeleteCuota($id)
    {
        $cuota = Cuota::find($id);

        return view('gestion_cuotas/delete_form_cuota', compact(["cuota"]));
    }

    /**
     * Elimina una cuota de la base de datos.
     *
     * @param  int  $id  ID de la cuota a eliminar.
     * @return \Illuminate\Http\RedirectResponse       Redirige a la lista de cuotas después de eliminar.
     */
    public function deleteCuota($id)
    {

        echo ($id);

        $cuota = Cuota::find($id);

        $cuota->delete();

        $mensaje = urlencode("Cuota # " . $cuota->id . " " . $cuota->concepto . " borrada correctamente");


        return redirect()->route('resultadoDelete', ["message" => $mensaje,  'route' => "listaCuotas"]);
    }
    /**
     * Genera las cuotas mensuales.
     *
     * @return \Illuminate\Http\RedirectResponse       Redirige a la lista de cuotas después de generar las cuotas mensuales.
     */
    public function cuotaMensual()
    {


        Cuota::genCuotaMensual();
        return redirect()->route('listaCuotas');
    }

    public function getPdf($id)
    {
        $cuota = Cuota::find($id);
        $cliente = Cliente::find($cuota->id_cliente);

        $cuota::sendMail($cliente, $cuota);
        return redirect()->route('listaCuotas');
    }
}
