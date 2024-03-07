<?php

namespace App\Http\Controllers;

use App\Http\Requests\usuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de usuarios.
 */
class usuarioController extends Controller
{
    /**
     * Muestra el formulario para agregar un nuevo usuario.
     *
     * @return \Illuminate\View\View Vista del formulario para agregar usuario.
     */
    public function usuarioForm()
    {
        $modo = "add";
        return view('gestion_usuarios/form_usuario', compact(["modo"]));
    }
    /**
     * Guarda un nuevo usuario o actualiza uno existente.
     *
     * @param  \App\Http\Requests\usuarioRequest  $request  Objeto que contiene los datos del usuario.
     * @param  string  $modo  Modo de operación ("add" para agregar, "mod" para modificar).
     * @return \Illuminate\View\View Redirecciona a la lista de usuarios.
     */
    public function saveUsuario(usuarioRequest $request, $modo)
    {
        $datosUsuario = $request->validated();


        if ($modo == "mod") {


            $usuario = (new Usuario())->actualizarUsuario($request->id, $request);

            return redirect()->route('listaUsuarios');
        } else if ($modo == "add") {

            $usuario = (new Usuario())->guardarUsuario($request);
            return redirect()->route('listaUsuarios');
        }

        return view('gestion_usuarios/form_usuario', compact(["modo"]));
    }
    /**
     * Muestra el formulario para modificar un usuario.
     *
     * @param  int  $id  ID del usuario a modificar.
     * @return \Illuminate\View\View Vista del formulario para modificar usuario.
     */
    public function modUsuario($id)
    {


        $modo = "mod";
        $usuario = Usuario::find($id);


        return view('gestion_usuarios/form_usuario', compact(["modo", "usuario"]));
    }

    /**
     * Muestra el formulario para confirmar el borrado de un usuario.
     *
     * @param  int  $id  ID del usuario a eliminar.
     * @return \Illuminate\View\View Vista del formulario de confirmación de eliminación de usuario.
     */
    public function formDeleteUsuario($id)
    {
        $usuario = Usuario::find($id);

        return view('gestion_usuarios/delete_form_usuario', compact(["usuario"]));
    }

    /**
     * Elimina un usuario.
     *
     * @param  int  $id  ID del usuario a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirecciona a la lista de usuarios.
     */
    public function deleteUsuario($id)
    {

        echo ($id);

        $usuario = Usuario::find($id);

        $usuario->delete();

        $mensaje = urlencode("Usuario # " . $usuario->id . " " . $usuario->nombre_usuario . " borrado correctamente");


        return redirect()->route('resultadoDelete', ['message' => $mensaje, 'route' => "listaUsuarios"]);
    }
}
