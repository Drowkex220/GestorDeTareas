<?php

namespace App\Http\Controllers;

use App\Http\Requests\clienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Controlador para la gestión de clientes.
 */
class clienteController extends Controller
{

    /**
     * Muestra el formulario para agregar un nuevo cliente.
     *
     * @return \Illuminate\View\View Vista con el formulario para agregar un cliente.
     */
    public function clienteForm()
    {

        $modo = "add";

        $currencies2 = Http::withOptions(['verify' => false])->get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies.json');

        $currencies2 = $currencies2->json();


        return view("gestion_clientes/form_cliente", compact("modo", "currencies2"));
    }


    /**
     * Guarda un cliente nuevo o actualizado en la base de datos.
     *
     * @param  \App\Http\Requests\clienteRequest  $request   Datos del cliente provenientes del formulario.
     * @param  string  $modo                                Modo de operación ('add' para agregar, 'mod' para modificar).
     * @return \Illuminate\View\View       Redirige a la lista de clientes después de guardar.
     */
    public function saveCliente(clienteRequest $request, $modo)
    {
        $datosCliente = $request->validated();

        //$cliente = (new Cliente())->guardarCliente($request);

        //echo ($cliente->nombre);



        if ($modo == "mod") {
            //echo("\nactualizando tarea #".$request->IDTarea);

            $cliente = (new Cliente())->actualizarCliente($request->id, $request);

            return redirect()->route('listaClientes');
        } else if ($modo == "add") {

            $cliente = (new Cliente())->guardarCliente($request);
            return redirect()->route('listaClientes');
        }



        return view("gestion_clientes/save_cliente");
    }


    /**
     * Muestra el formulario para modificar un cliente existente.
     *
     * @param  int  $id  ID del cliente a modificar.
     * @return \Illuminate\View\View Vista con el formulario para modificar un cliente.
     */
    public function modCliente($id)
    {

        $modo = "mod";
        $cliente = Cliente::find($id);

        $currencies2 = Http::withOptions(['verify' => false])->get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies.json');

        $currencies2 = $currencies2->json();


        return view("gestion_clientes/form_cliente", compact("cliente", "modo", "currencies2"));
    }

    /**
     * Muestra el formulario para eliminar un cliente.
     *
     * @param  int  $id  ID del cliente a eliminar.
     * @return \Illuminate\View\View Vista con el formulario para eliminar un cliente.
     */
    public function formDeleteCliente($id)
    {
        $cliente = Cliente::find($id);



        return view('gestion_clientes/delete_form_cliente', compact(["cliente"]));
    }
    /**
     * Elimina un cliente de la base de datos.
     *
     * @param  int  $id  ID del cliente a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirige a la lista de clientes después de eliminar.
     */
    public function deletecliente($id)
    {

        echo ($id);

        $cliente = Cliente::find($id);

        $cliente->delete();


        $mensaje = urlencode("Cliente # " . $cliente->id . " " . $cliente->nombre . " borrado correctamente");



        return redirect()->route('resultadoDelete', ["message" => $mensaje,  'route' => "listaClientes"]);
    }
    /**
     * Muestra el formulario de autenticación de cliente.
     *
     * @return \Illuminate\View\View Vista con el formulario de autenticación de cliente.
     */
    public function authCliente()
    {

        return view("gestion_clientes/auth_cliente");
    }
    /**
     * Verifica la autenticación de un cliente.
     *
     * @param  \Illuminate\Http\Request  $request   Datos del formulario de autenticación.
     * @return \Illuminate\View\View       Vista con el resultado de la autenticación.
     */
    public function checkAuthCliente(Request $request)
    {

        // Verifica si se proporcionó un CIF
        if (!isset($request->cif)) {
            $error = "Introduzca un CIF";
            return view('gestion_clientes/auth_cliente', compact("error"));
        } else {
            // Busca el CIF en la tabla de clientes
            $cliente = Cliente::where('cif', $request->cif)->first();

            // Verifica si se encontró un cliente con el CIF dado
            if ($cliente) {
                return redirect()->route('addTareas');
            } else {
                // El CIF no existe en la tabla de clientes
                $error = "El CIF proporcionado no existe en nuestra base de datos";
                return view('gestion_clientes/auth_cliente', compact("error"));
            }
        }
    }
}
