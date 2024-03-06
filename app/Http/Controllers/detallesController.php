<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Storage;


class detallesController extends Controller
{
    public function detallesTarea($id) {
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
