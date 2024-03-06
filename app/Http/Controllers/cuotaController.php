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

class cuotaController extends Controller
{
    public function cuotaForm()
    {
        $modo = "add";
        $cuotas = Cuota::all();
        $tareas = Tarea::all();
        $clientes = Cliente::all();

        echo("modo modificar");
        return view("gestion_cuotas/form_cuota", compact("cuotas", "tareas", "clientes", "modo"));
    }

    public function saveCuota(cuotaRequest $request, $modo)
    {
        $datosCuota = $request->validated();
        //echo ($request->id);


        if ($modo == "mod") {


            $cuota = (new Cuota())->actualizarCuota($request->id, $request);

            echo("Modificado");
            return redirect()->route('listaCuotas');
        } else if ($modo == "add") {

            $cuota = (new Cuota())->guardarCuota($request);

            echo("Añadido");
            return redirect()->route('listaCuotas');
        }


        return view("gestion_cuotas/save_cuota");
    }

    public function modCuota($id)
    {
        $modo = "mod";
        $cuota = Cuota::find($id);
        $cuotas = Cuota::all();
        $tareas = Tarea::all();
        $clientes = Cliente::all();

        echo("modo modificar");
        return view("gestion_cuotas/form_cuota", compact("modo", "cuota", "cuotas", "tareas", "clientes"));
    }

    public function formDeleteCuota($id)
    {
        $cuota = Cuota::find($id);

        return view('gestion_cuotas/delete_form_cuota', compact(["cuota"]));
    }


    public function deleteCuota($id)
    {

        echo ($id);

        $cuota = Cuota::find($id);

        $cuota->delete();

        $mensaje = urlencode("Cuota # " . $cuota->id . " " . $cuota->concepto . " borrada correctamente");


        return redirect()->route('resultadoDelete', ["message" => $mensaje,  'route' => "listaCuotas"]);
    }

    public function cuotaMensual() {


        Cuota::genCuotaMensual();
        return redirect()->route('listaCuotas');

    }
}
