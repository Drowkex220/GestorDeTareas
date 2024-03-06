<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\tareaRequest;
use App\Http\Requests\updateTareaRequest;


class Tarea extends Model
{
    protected $table = 'tareas';
    protected $primaryKey = 'IDTarea';
    public $timestamps = false;

    protected $fillable = [
        'NIF_CIF',
        'PersonaContactoNombre',
        'PersonaContactoApellidos',
        'TelefonoContacto',
        'Descripcion',
        'CorreoElectronico',
        'Direccion',
        'Poblacion',
        'CodigoPostal',
        'ProvinciaCodigo',
        'Estado',
        'FechaCreacion',
        'OperarioEncargado',
        'FechaRealizacion',
        'AnotacionesAnteriores',
        'AnotacionesPosteriores',
        'FicheroResumen',
        'FotosTrabajoRealizado'
    ];


    /**
     * Obtiene todas las tareas desde la base de datos
     */
    public function obtenerTodasLasTareas()
    {
        return $this::all();
    }


    /**
     * Obtiene solo las tareas con el estado en 'P'
     */
    public function obtenerTareasPendientes()
    {
        return $this::where('Estado', 'P')->get();
    }


    /**
     * Se le pasa un ID a la funcion y se realiza una query a la base de datos por los registros con dicho id
     */
    public function obtenerTareaPorId($id)
    {
        return $this::find($id);
    }

    /**
     * Permite guardar la tarea en la base de datos dado un objeto request con la informacion necesaria
     */
    public static function guardarTarea(tareaRequest $request)
    {
        // Crear una nueva instancia del modelo Tarea
        $tarea = new Tarea();

        // Llenar el modelo con los datos del formulario
        $tarea->fill($request->all());


        echo 'NIF_CIF: ' . $tarea->NIF_CIF;
        //print_r($tarea);
        // Guardar el modelo en la base de datos
        $tarea->save();

        // Devolver la instancia de la Tarea guardada
        return $tarea;
    }

    public function actualizarTarea($id, tareaRequest $request)
    {
        // Obtener la tarea por su ID
        $tarea = Tarea::find($id);
        echo ("id: " . $id);
        echo ("request ID:" . $request->IDTarea);

        // Verificar si la tarea existe
        if (!$tarea) {
            //echo($tarea->IDTarea);
            echo ("tarea no encontrada");
            return response()->json(['mensaje' => 'Tarea no encontrada'], 404);
        }



        // Actualizar los atributos de la tarea con los datos del formulario
        $tarea->fill($request->all());


        echo ("antiguo: " . $tarea->persona_contacto_nombre . " nuevo: " . $request->persona_contacto_nombre);

        // Guardar los cambios en la base de datos
        $tarea->save();

        // Retornar una respuesta exitosa
        return response()->json(['mensaje' => 'Tarea actualizada correctamente'], 200);
    }

    public function updateTarea($id, updateTareaRequest $request)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return redirect()->back()->with('error', 'La tarea no pudo ser encontrada.');
        }

        // Actualizar cada campo de la tarea con los nuevos valores del formulario
        $tarea->Estado = $request->Estado;
        $tarea->FechaRealizacion = $request->FechaRealizacion;
        $tarea->AnotacionesAnteriores = $request->AnotacionesAnteriores;
        $tarea->AnotacionesPosteriores = $request->AnotacionesPosteriores;

        dd($tarea);

        // Guardar el archivo de resumen
        if ($request->hasFile('FicheroResumen')) {
            $resumenPath = $request->file('FicheroResumen')->store('public/resumen');
            $tarea->FicheroResumen = $resumenPath;
        }

        // Guardar las imágenes del trabajo realizado
        if ($request->hasFile('FotosTrabajoRealizado')) {
            $fotosPaths = [];
            foreach ($request->file('FotosTrabajoRealizado') as $foto) {
                $fotoPath = $foto->store('public/img');
                $fotosPaths[] = $fotoPath;
            }
            $tarea->FotosTrabajoRealizado = implode(',', $fotosPaths);
        }

        // Guardar los cambios en la base de datos
        $tarea->save();

        //return redirect()->route('tareasPend')->with('success', 'Tarea actualizada correctamente.');
    }

}
