<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;




class loginController extends Controller
{
    /**
     * Mostrar vista
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
     * Handle an authentication attempt.
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

            return redirect()->route('tareasPend');
        } else {

            return back()->withErrors([
                'nombre_usuario' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ]);
        }
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }


    /**
     * Cerrar sesión
     */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('tareasPend');
    }
}
