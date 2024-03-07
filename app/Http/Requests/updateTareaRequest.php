<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * Clase para manejar las solicitudes de actualización de tarea.
 */
class updateTareaRequest extends FormRequest
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
            'IDTarea' => 'required',
            'Estado' => 'required',
            'FechaRealizacion' => 'nullable|date',
            'AnotacionesAnteriores' => 'nullable|string',
            'AnotacionesPosteriores' => 'nullable|string',
            'FicheroResumen' => 'nullable|file',
            'FotosTrabajoRealizado.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
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
            'IDTarea.required' => 'El ID es obligatorio',
            'Estado.required' => 'El estado es obligatorio.',
            'FechaRealizacion.date' => 'La fecha de realización debe ser una fecha válida.',
            'AnotacionesAnteriores.string' => 'Las anotaciones anteriores deben ser texto.',
            'AnotacionesPosteriores.string' => 'Las anotaciones posteriores deben ser texto.',
            'FicheroResumen.file' => 'El fichero resumen debe ser un archivo.',
            'FotosTrabajoRealizado.*.file' => 'Las fotos del trabajo realizado deben ser archivos.',
            'FotosTrabajoRealizado.*.mimes' => 'Las fotos del trabajo realizado deben ser de tipo: jpeg, png, jpg, gif.',
            'FotosTrabajoRealizado.*.max' => 'El tamaño máximo permitido para las fotos del trabajo realizado es de 2048 KB.',
        ];
    }
}
