<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class cuotaRequest extends FormRequest
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
            'concepto' => 'required|string|max:255',
            'fecha_emision' => 'required|date',
            'importe' => 'required|numeric',
            'pagada' => 'required|string',
            'fecha_pago' => 'nullable|date',
            'notas' => 'nullable|string|max:255',
            'id_tarea' => 'required',
            'id_cliente' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'cif.required' => 'El CIF es obligatorio.',
            'cif.string' => 'El CIF debe ser una cadena de caracteres.',
            'cif.max' => 'El CIF no puede tener más de :max caracteres.',
            'concepto.required' => 'El concepto es obligatorio.',
            'concepto.string' => 'El concepto debe ser una cadena de caracteres.',
            'concepto.max' => 'El concepto no puede tener más de :max caracteres.',
            'fecha_emision.required' => 'La fecha de emisión es obligatoria.',
            'fecha_emision.date' => 'La fecha de emisión debe ser una fecha válida.',
            'importe.required' => 'El importe es obligatorio.',
            'importe.numeric' => 'El importe debe ser un valor numérico.',
            'pagada.required' => 'El campo "pagada" es obligatorio.',
            'pagada.boolean' => 'El campo "pagada" debe ser un valor booleano.',
            'fecha_pago.date' => 'La fecha de pago debe ser una fecha válida.',
            'notas.string' => 'Las notas deben ser una cadena de caracteres.',
            'notas.max' => 'Las notas no pueden tener más de :max caracteres.',
            'id_tarea.required' => 'El ID de tarea es obligatorio.',
            'id_cliente.required' => 'Debe escoger un cliente'
        ];
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!$this->validDniCifNie($this->input("cif"))) {
                    $validator->errors()->add(
                        'cif',
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
