<?php

namespace App\Models;

use App\Http\Requests\cuotaRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


use App\Mail\correoMensual;
use Illuminate\Support\Facades\Mail;

class Cuota extends Model
{

    protected $table = 'cuotas';

    protected  $primaryKey = "id";

    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'id_cuota',
        'cif',
        'concepto',
        'fecha_emision',
        'importe',
        'pagada',
        'fecha_pago',
        'notas',
        'id_cliente',
        'id_tarea'
        // Agrega aquí otros campos si es necesario
    ];


    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }


    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class, 'id_tarea', 'IDTarea');
    }


    /**
     *Permite guardar la cuota en la base de datos dado un objeto request
     */

    public static function guardarCuota(cuotaRequest $request)
    {

        $cuota = new Cuota();

        $cuota->fill([
            'cif' => $request->cif,
            'concepto' => $request->concepto,
            'fecha_emision' => $request->fecha_emision,
            'importe' => $request->importe,
            'pagada' => $request->pagada,
            'fecha_pago' => $request->fecha_pago,
            'notas' => $request->notas,
            'id_cliente' => $request->id_cliente,
            'id_tarea' => $request->id_tarea,
        ]);

        print_r($cuota);

        $cuota->save();

        return $cuota;
    }

    public function actualizarCuota($id, cuotaRequest $request)
    {
        // Obtener la tarea por su ID
        $cuota = Cuota::find($id);
        echo ("id: " . $id);
        echo ("request ID:" . $request->id);

        // Verificar si la tarea existe
        if (!$cuota) {
            //echo($tarea->IDTarea);
            echo ("Cuota no encontrada");
            return response()->json(['mensaje' => 'Cuota no encontrada'], 404);
        }



        // Actualizar los atributos de la tarea con los datos del formulario
        $cuota->fill($request->all());


        echo ("antiguo: " . $cuota->concepto . " nuevo: " . $request->concepto);

        // Guardar los cambios en la base de datos
        $cuota->save();

        // Retornar una respuesta exitosa
        return response()->json(['mensaje' => 'Cuota actualizada correctamente'], 200);
    }


    public static function genCuotaMensual()
    {
        // Obtener todos los clientes
        $clientes = Cliente::all();

        // Iterar sobre los clientes y generar una cuota para cada uno
        foreach ($clientes as $cliente) {
            // Crear una nueva cuota
            $cuota = new Cuota();
            $cuota->cif = $cliente->cif; // Asignar el CIF del cliente a la cuota
            $cuota->concepto = 'Cuota mensual'; // Concepto de la cuota
            $cuota->fecha_emision = now(); // Usar la fecha actual como fecha de emisión de la cuota
            $cuota->importe = $cliente->importe_c_mensual; // Usar el importe mensual del cliente
            $cuota->pagada = false;
            $cuota->id_cliente = $cliente->id; // Asignar el ID del cliente a la cuota

            $datos = $cliente;


            $pdf = self::genPDF($datos->toArray());

            // Enviar el correo con el PDF adjunto


            Mail::to($cliente->correo)->send(new correoMensual($datos, $pdf));


            // Guardar la cuota en la base de datos
            $cuota->save();
        }
    }

    public static function genPDF($data)
    {

        $currentCurrency = Http::withOptions(['verify' => false])->get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/eur.json');
        $currencies = Http::withOptions(['verify' => false])->get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies.json');

        $currentCurrency = $currentCurrency->json();
        $currencies = $currencies->json();

        $conversion = $currentCurrency['eur'][$data['moneda']];
        $moneda = $currencies[$data['moneda']];
        // Cambiar el nombre de la variable de datos a 'cliente'
        $pdf = Pdf::loadView('pdf.pdfFactura', ['data' => $data, 'conversion' => $conversion, "moneda" => $moneda]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return $pdf;
    }
}
