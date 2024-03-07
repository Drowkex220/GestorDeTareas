<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;





/**
 * Controlador para la autenticación de usuarios.
 */
class loginController extends Controller
{

    /**
     * Muestra el formulario de inicio de sesión.
     *
     * Si el usuario ya está autenticado, redirige a la ruta 'tareasPend'; de lo contrario, muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Vista del formulario de inicio de sesión o redireccionamiento a 'tareasPend'.
     */
    public function loginForm()
    {
        if (Auth::viaRemember()) {
            return redirect()->route('tareasPend');
        } else {
            return view("login/form_login");
        }
    }

    /**
     * Autentica al usuario.
     *
     * Valida las credenciales proporcionadas en el formulario de inicio de sesión. Si las credenciales son válidas, autentica al usuario y actualiza su última sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse Redirecciona a 'tareasPend' si la autenticación es exitosa; de lo contrario, vuelve al formulario de inicio de sesión con un mensaje de error.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'nombre_usuario' => ['required'],
            'password' => ['required'],
        ]);


        Log::debug("Credenciales: " . $request->nombre_usuario);

        if (Auth::attempt($credentials, $request->recordar)) {
            $request->session()->regenerate();


            $now = Carbon::now();

            // Agregamos una hora a la fecha y hora actual
            $newLastSession = $now->addHour();
            Usuario::where('nombre_usuario', $credentials['nombre_usuario'])
                ->update(['last_sesion' => $newLastSession]);
            return redirect()->route('tareasPend');
        } else {

            return back()->withErrors([
                'nombre_usuario' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ]);
        }
    }

    /**
     * Obtiene el nombre de usuario para la autenticación.
     *
     * @return string Nombre de usuario
     */
    public function username()
    {
        return 'username';
    }



    /**
     * Cierra la sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse Redirecciona a 'tareasPend' después de cerrar la sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('tareasPend');
    }
}
