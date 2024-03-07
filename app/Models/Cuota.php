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

/**
 * Clase Cuota
 *
 * Esta clase representa una cuota en el sistema.
 *
 * @package App\Models
 */
class Cuota extends Model
{

    /**
     * Nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'cuotas';

    /**
     * Nombre de la clave primaria del modelo.
     *
     * @var string
     */
    protected  $primaryKey = "id";

    /**
     * Indica si el modelo debe ser marcado con marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = false;

    use HasFactory;
    /**
     * Los atributos que son asignables.
     *
     * @var array
     */
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

    /**
     * Define la relación con el modelo Cliente.
     *
     * @return BelongsTo
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }

    /**
     * Define la relación con el modelo Tarea.
     *
     * @return BelongsTo
     */
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class, 'id_tarea', 'IDTarea');
    }

    /**
     * Guarda una nueva cuota en la base de datos.
     *
     * @param cuotaRequest $request Los datos de la cuota proporcionados por el formulario
     * @return Cuota
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
    /**
     * Actualiza una cuota existente en la base de datos.
     *
     * @param int $id El ID de la cuota
     * @param cuotaRequest $request Los datos de la cuota proporcionados por el formulario
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Genera cuotas mensuales para todos los clientes y las envía por correo electrónico.
     *
     * @return void
     */
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

    public static function sendMail($cliente, $cuota)
    {
        $datos = $cliente;


        $pdf = self::genPDF($datos->toArray(), $cuota);

        // Enviar el correo con el PDF adjunto


        Mail::to($cliente->correo)->send(new correoMensual($datos, $pdf));
    }

    /**
     * Genera un PDF para la cuota mensual.
     *
     * @param array $data Los datos del cliente
     * @return \Barryvdh\DomPDF\PDF
     */
    public static function genPDF($data, $cuota = null)
    {

        $currentCurrency = Http::withOptions(['verify' => false])->get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/eur.json');
        $currencies = Http::withOptions(['verify' => false])->get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies.json');

        $currentCurrency = $currentCurrency->json();
        $currencies = $currencies->json();

        $conversion = $currentCurrency['eur'][$data['moneda']];
        $moneda = $currencies[$data['moneda']];
        $fecha_emision = now();

        if ($cuota == null) {
            $cuota = "factura mensual";
            $pdf = Pdf::loadView('pdf.pdfFactura', ['data' => $data, 'conversion' => $conversion, "moneda" => $moneda, "fecha_emision" => $fecha_emision]);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            return $pdf;
        } else {
            // Cambiar el nombre de la variable de datos a 'cliente'
            $pdf = Pdf::loadView('pdf.pdfFactura', ['data' => $data, 'conversion' => $conversion, "moneda" => $moneda, "fecha_emision" => $fecha_emision, "cuota" => $cuota]);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            return $pdf;
        }



    }
}
