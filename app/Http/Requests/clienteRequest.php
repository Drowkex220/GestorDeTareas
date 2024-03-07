<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

/**
 * Clase para manejar las solicitudes de cliente.
 */
class clienteRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar la solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'cif' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'cuenta_corriente' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'moneda' => 'required|string|max:255',
            'importe_c_mensual' => 'required|numeric',
            // Añade más reglas de validación según sea necesario
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
            'cif.required' => 'El campo CIF es obligatorio.',
            'nombre.required' => 'El campo Nombre es obligatorio.',
            'telefono.required' => 'El campo Teléfono es obligatorio.',
            'correo.required' => 'El campo Correo Electrónico es obligatorio.',
            'correo.email' => 'El campo Correo Electrónico debe ser una dirección de correo válida.',
            'cuenta_corriente.required' => 'El campo Cuenta Corriente es obligatorio.',
            'pais.required' => 'El campo País es obligatorio.',
            'moneda.required' => 'El campo Moneda es obligatorio.',
            'importe_c_mensual.required' => 'El campo Importe Cuota Mensual es obligatorio.',
            'importe_c_mensual.numeric' => 'El campo Importe Cuota Mensual debe ser un valor numérico.',
            // Añade más mensajes según sea necesario
        ];
    }


    /**
     * Realiza validaciones adicionales después de que se hayan aplicado las reglas de validación predeterminadas.
     *
     * @return array
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!$this->validDniCifNie($this->input("cif"))) {
                    $validator->errors()->add(
                        'NIF_CIF',
                        'No es un CIF valido'
                    );
                }
                if ($this->isValidIBAN($this->input("cuenta_corriente"))) {
                } else {
                    $validator->errors()->add(
                        'cuenta_corriente',
                        'No es una Cuenta corriente valida '
                    );
                }
            }
        ];
    }



    /**
     * Valida el formato del CIF (Código de Identificación Fiscal).
     *
     * @param  string  $cif  CIF a validar.
     * @return bool  True si el CIF es válido, de lo contrario, false.
     */
    function validDniCifNie($dni)
    {
        $cif = strtoupper($dni);
        for ($i = 0; $i < 9; $i++) {
            $num[$i] = substr($cif, $i, 1);
        }
        // Si no tiene un formato valido devuelve error
        if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif)) {
            return false;
        }
        // Comprobacion de NIFs estandar
        if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $cif)) {
            if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1)) {
                return true;
            } else {
                return false;
            }
        }
        // Algoritmo para comprobacion de codigos tipo CIF
        $suma = $num[2] + $num[4] + $num[6];
        for ($i = 1; $i < 8; $i += 2) {
            $suma += (int)substr((2 * $num[$i]), 0, 1) + (int)substr((2 * $num[$i]), 1, 1);
        }
        $n = 10 - substr($suma, strlen($suma) - 1, 1);
        // Comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
        if (preg_match('/^[KLM]{1}/', $cif)) {
            if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1)) {
                return true;
            } else {
                return false;
            }
        }
        // Comprobacion de CIFs
        if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif)) {
            if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1)) {
                return true;
            } else {
                return false;
            }
        }
        // Comprobacion de NIEs
        // T
        if (preg_match('/^[T]{1}/', $cif)) {
            if ($num[8] == preg_match('/^[T]{1}[A-Z0-9]{8}$/', $cif)) {
                return true;
            } else {
                return false;
            }
        }
        // XYZ
        if (preg_match('/^[XYZ]{1}/', $cif)) {
            if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X', 'Y', 'Z'), array('0', '1', '2'), $cif), 0, 8) % 23, 1)) {
                return true;
            } else {
                return false;
            }
        }
        // Si todavía no se ha verificado devuelve error
        return false;
    }
    /**
     * Valida el formato de la cuenta corriente IBAN.
     *
     * @param  string  $iban  IBAN a validar.
     * @return bool  True si el IBAN es válido, de lo contrario, false.
     */
    function isValidIBAN($iban)
    {

        $iban = strtolower($iban);
        $Countries = array(
            'al' => 28, 'ad' => 24, 'at' => 20, 'az' => 28, 'bh' => 22, 'be' => 16, 'ba' => 20, 'br' => 29, 'bg' => 22, 'cr' => 21, 'hr' => 21, 'cy' => 28, 'cz' => 24,
            'dk' => 18, 'do' => 28, 'ee' => 20, 'fo' => 18, 'fi' => 18, 'fr' => 27, 'ge' => 22, 'de' => 22, 'gi' => 23, 'gr' => 27, 'gl' => 18, 'gt' => 28, 'hu' => 28,
            'is' => 26, 'ie' => 22, 'il' => 23, 'it' => 27, 'jo' => 30, 'kz' => 20, 'kw' => 30, 'lv' => 21, 'lb' => 28, 'li' => 21, 'lt' => 20, 'lu' => 20, 'mk' => 19,
            'mt' => 31, 'mr' => 27, 'mu' => 30, 'mc' => 27, 'md' => 24, 'me' => 22, 'nl' => 18, 'no' => 15, 'pk' => 24, 'ps' => 29, 'pl' => 28, 'pt' => 25, 'qa' => 29,
            'ro' => 24, 'sm' => 27, 'sa' => 24, 'rs' => 22, 'sk' => 24, 'si' => 19, 'es' => 24, 'se' => 24, 'ch' => 21, 'tn' => 24, 'tr' => 26, 'ae' => 23, 'gb' => 22, 'vg' => 24
        );
        $Chars = array(
            'a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18, 'j' => 19, 'k' => 20, 'l' => 21, 'm' => 22,
            'n' => 23, 'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29, 'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34, 'z' => 35
        );

        if (strlen($iban) != $Countries[substr($iban, 0, 2)]) {
            return false;
        }

        $MovedChar = substr($iban, 4) . substr($iban, 0, 4);
        $MovedCharArray = str_split($MovedChar);
        $NewString = "";

        foreach ($MovedCharArray as $k => $v) {

            if (!is_numeric($MovedCharArray[$k])) {
                $MovedCharArray[$k] = $Chars[$MovedCharArray[$k]];
            }
            $NewString .= $MovedCharArray[$k];
        }
        if (function_exists("bcmod")) {
            return bcmod($NewString, '97') == 1 ? true : false;
        }

        // http://au2.php.net/manual/en/function.bcmod.php#38474
        $x = $NewString;
        $y = "97";
        $take = 5;
        $mod = "";

        do {
            $a = (int)$mod . substr($x, 0, $take);
            $x = substr($x, $take);
            $mod = $a % $y;
        } while (strlen($x));

        return (int)$mod == 1 ? true : false;
    }
}
