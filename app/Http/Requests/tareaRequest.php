<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class tareaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'NIF_CIF' => 'required|string',
            'Descripcion' => 'required|string',
            'OperarioEncargado' => 'nullable',
            'FechaCreacion' => 'required|date',
            'PersonaContactoNombre' => 'required|string|min:3|regex:/^[A-Z]/',
            'PersonaContactoApellidos' => 'required|string',
            'TelefonoContacto' => 'required|string|regex:/^\+?\d{8,15}$/',
            'CorreoElectronico' => 'required|email',
            'Provincia' => 'required',
            'Direccion' => 'required|string',
            'Poblacion' => 'required|string',
            'CodigoPostal' => 'required|numeric|digits_between:4,10',
        ];
    }

    public function messages()
    {
        return [
            'NIF_CIF.required' => 'El campo NIF/CIF es obligatorio.',
            'NIF_CIF.size' => 'El NIF/CIF debe tener exactamente :size caracteres.',
            'Descripcion.required' => 'El campo Descripción es obligatorio.',
            'PersonaContactoNombre.required' => 'El campo Nombre de persona de contacto es obligatorio.',
            'PersonaContactoNombre.min' => 'El Nombre de persona de contacto debe tener al menos :min caracteres.',
            'PersonaContactoNombre.regex' => 'El Nombre de persona de contacto debe empezar con mayúscula.',
            'PersonaContactoApellidos.required' => 'El campo Apellidos de persona de contacto es obligatorio.',
            'PersonaContactoApellidos.min' => 'Los Apellidos de persona de contacto deben tener al menos :min caracteres.',
            'PersonaContactoApellidos.regex' => 'Los Apellidos de persona de contacto deben empezar con mayúscula.',
            'TelefonoContacto.required' => 'El campo Teléfono de contacto es obligatorio.',
            'TelefonoContacto.numeric' => 'El Teléfono de contacto debe ser un número.',
            'TelefonoContacto.regex' => 'El Teléfono de contacto debe ser del formato correcto.',
            'CorreoElectronico.required' => 'El campo Correo Electrónico es obligatorio.',
            'CorreoElectronico.email' => 'El Correo Electrónico debe ser una dirección de correo válida.',
            'Direccion.required' => 'El campo Dirección es obligatorio.',
            'Poblacion.required' => 'El campo Población es obligatorio.',
            'CodigoPostal.required' => 'El campo Código Postal es obligatorio.',
            'CodigoPostal.numeric' => 'El Código Postal debe ser un número.',
            'CodigoPostal.regex' => 'El Código Postal debe del formato correcto.',

            'Provincia.required' => 'Debes seleccionar una Provincia.',
            'FechaCreacion.required' => 'El campo Fecha de creación es obligatorio.',
            'FechaCreacion.date' => 'La Fecha de creación debe ser una fecha válida.',
            'OperarioEncargado.required' => 'Debes seleccionar un operario encargado.',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!$this->validDniCifNie($this->input("NIF_CIF"))) {
                    $validator->errors()->add(
                        'NIF_CIF',
                        'No es un CIF valido'
                    );
                }
            }
        ];
    }




    function validDniCifNie($dni){
        $cif = strtoupper($dni);
        for ($i = 0; $i < 9; $i ++){
          $num[$i] = substr($cif, $i, 1);
        }
        // Si no tiene un formato valido devuelve error
        if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif)){
          return false;
        }
        // Comprobacion de NIFs estandar
        if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $cif)){
          if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1)){
            return true;
          }else{
            return false;
          }
        }
        // Algoritmo para comprobacion de codigos tipo CIF
        $suma = $num[2] + $num[4] + $num[6];
        for ($i = 1; $i < 8; $i += 2){
          $suma += (int)substr((2 * $num[$i]),0,1) + (int)substr((2 * $num[$i]), 1, 1);
        }
        $n = 10 - substr($suma, strlen($suma) - 1, 1);
        // Comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
        if (preg_match('/^[KLM]{1}/', $cif)){
          if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1)){
            return true;
          }else{
            return false;
          }
        }
        // Comprobacion de CIFs
        if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif)){
          if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1)){
            return true;
          }else{
            return false;
          }
        }
        // Comprobacion de NIEs
        // T
        if (preg_match('/^[T]{1}/', $cif)){
          if ($num[8] == preg_match('/^[T]{1}[A-Z0-9]{8}$/', $cif)){
            return true;
          }else{
            return false;
          }
        }
        // XYZ
        if (preg_match('/^[XYZ]{1}/', $cif)){
          if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1)){
            return true;
          }else{
            return false;
          }
        }
        // Si todavía no se ha verificado devuelve error
        return false;
      }
}
