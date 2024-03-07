<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


/**
 * Clase para manejar las solicitudes de actualización de tarea.
 */
class usuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        // Aquí puedes colocar la lógica de autorización si es necesario.
        // Por ejemplo, determinar si el usuario actual tiene permiso para realizar la acción.
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255' /*|unique:usuariosgt,nombre_usuario'*/, // Verifica que el nombre de usuario sea único en la tabla 'usuariosgt'
            'contrasena' => 'required|string|min:6',
            'contrasenaR' => 'required|string|min:6',
            'permiso' => 'required|string|in:operario,admin', // Asegura que el permiso solo sea 'operario' o 'admin'
            // Agrega aquí otras reglas de validación según tus necesidades
        ];
    }

    /**
     * Obtiene los mensajes de error para las reglas de validación definidas.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de caracteres.',
            'nombre.max' => 'El nombre no puede tener más de :max caracteres.',
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.string' => 'El nombre de usuario debe ser una cadena de caracteres.',
            'nombre_usuario.max' => 'El nombre de usuario no puede tener más de :max caracteres.',
            //'nombre_usuario.unique' => 'El nombre de usuario ya está en uso.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.string' => 'La contraseña debe ser una cadena de caracteres.',
            'contrasena.min' => 'La contraseña debe tener al menos :min caracteres.',
            'contrasenaR.required' => 'La contraseña es obligatoria.',
            'contrasenaR.string' => 'La contraseña debe ser una cadena de caracteres.',
            'contrasenaR.min' => 'La contraseña debe tener al menos :min caracteres.',
            'permiso.required' => 'El permiso es obligatorio.',
            'permiso.string' => 'El permiso debe ser una cadena de caracteres.',
            'permiso.in' => 'El permiso seleccionado no es válido.',
            // Agrega aquí otros mensajes de error según tus necesidades
        ];
    }
    /**
     * Realiza validaciones adicionales después de que se aplican las reglas de validación estándar.
     *
     * @return array
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!$this->checkPassword($this->input("contrasenaR"), $this->input("contrasena"))) {
                    $validator->errors()->add(
                        'contrasenaR',
                        'Las contraseñas no coinciden'
                    );
                }
            }
        ];
    }
    /**
     * Comprueba si las contraseñas coinciden.
     *
     * @param string $passR Contraseña a confirmar
     * @param string $pass Contraseña original
     * @return bool true si las contraseñas coinciden, false de lo contrario
     */
    public function checkPassword($passR, $pass)
    {
        if ($passR == $pass) {
            return true;
        } else {
            return false;
        }
    }
}
