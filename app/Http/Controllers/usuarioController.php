<?php

namespace App\Http\Controllers;

use App\Http\Requests\usuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;

class usuarioController extends Controller
{
    public function usuarioForm()
    {
        $modo = "add";
        return view('gestion_usuarios/form_usuario', compact(["modo"]));
    }

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



    }

    public function modUsuario($id)
    {


        $modo = "mod";
        $usuario = Usuario::find($id);


        return view('gestion_usuarios/form_usuario', compact(["modo", "usuario"]));
    }


    public function formDeleteUsuario($id)
    {
        $usuario = Usuario::find($id);

        return view('gestion_usuarios/delete_form_usuario', compact(["usuario"]));
    }

    public function deleteUsuario($id)
    {

        echo ($id);

        $usuario = Usuario::find($id);

        $usuario->delete();

        $mensaje = urlencode("Tarea # " . $usuario->id . " " . $usuario->nombre_usuario . " borrado correctamente");


        return redirect()->route('resultadoDelete', ['message' => $mensaje, 'route' => "listaUsuarios"]);
    }
}
