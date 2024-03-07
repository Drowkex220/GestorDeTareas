<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Storage;


/**
 * Controlador para mostrar los detalles de una tarea.
 */
class detallesController extends Controller
{
    /**
     * Muestra los detalles de una tarea específica.
     *
     * @param  int  $id  ID de la tarea.
     * @return \Illuminate\View\View       Vista con los detalles de la tarea.
     */
    public function detallesTarea($id)
    {
        $tarea = Tarea::find($id);

        // Obtener la URL del archivo de resumen, si existe
        $resumenUrl = $tarea->FicheroResumen ? Storage::url($tarea->FicheroResumen) : null;

        // Obtener las URLs de las fotos del trabajo realizado, si existen
        $fotosUrls = [];
        if ($tarea->FotosTrabajoRealizado) {
            $fotos = explode(',', $tarea->FotosTrabajoRealizado);
            foreach ($fotos as $foto) {
                if ($foto) {
                    $fotosUrls[] = Storage::url($foto);
                }
            }
        }

        return view('verDatos/datosTarea', compact("tarea", "resumenUrl", "fotosUrls"));
    }
}
