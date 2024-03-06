<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class clienteRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
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


    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!$this->validarCIF($this->input("cif"))) {
                    $validator->errors()->add(
                        'NIF_CIF',
                        'No es un CIF valido'
                    );
                }
                if ($this->isValidIBAN($this->input("cuenta_corriente"))) {

                } else{
                    $validator->errors()->add(
                        'cuenta_corriente',
                        'No es una Cuenta corriente valida '
                    );
                }
            }
        ];
    }




    public function validarCIF($cif)
    {
        // Eliminar espacios en blanco y convertir a mayúsculas
        $cif = strtoupper(trim($cif));

        // Expresión regular para verificar el formato del CIF
        $formatoCorrecto = '/^[ABCDEFGHJNPQRSUVW][0-9]{7}[0-9A-J]$/';

        // Verificar si el CIF tiene el formato correcto
        if (!preg_match($formatoCorrecto, $cif)) {
            return false; // Devolver false si el formato es incorrecto
        }

        $cif_codes = 'JABCDEFGHI';
        $sum = (string)$this->getCifSum($cif);
        $n = (10 - substr($sum, -1)) % 10;

        if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif)) {
            if (in_array($cif[0], array('A', 'B', 'E', 'H'))) {
                // Numerico
                return ($cif[8] == $n);
            } elseif (in_array($cif[0], array('K', 'P', 'Q', 'S'))) {
                // Letras
                return ($cif[8] == $cif_codes[$n]);
            } else {
                // Alfanumérico
                if (is_numeric($cif[8])) {
                    return ($cif[8] == $n);
                } else {
                    return ($cif[8] == $cif_codes[$n]);
                }
            }
        }

        return false;
    }


    function getCifSum($cif)
    {
        $sum = $cif[2] + $cif[4] + $cif[6];

        for ($i = 1; $i < 8; $i += 2) {
            $tmp = (string) (2 * $cif[$i]);

            $tmp = $tmp[0] + ((strlen($tmp) == 2) ?  $tmp[1] : 0);

            $sum += $tmp;
        }

        return $sum;
    }

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
