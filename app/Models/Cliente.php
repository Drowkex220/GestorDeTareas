<?php

namespace App\Models;

use App\Http\Requests\clienteRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Cliente
 *
 * Esta clase representa un cliente en el sistema.
 *
 * @package App\Models
 */
class Cliente extends Model
{

    /**
     * Nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'clientes';


    /**
     * Nombre de la clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indica si el modelo debe ser marcado con marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Los atributos que son asignables.
     *
     * @var array
     */
    protected $fillable = [
        'cif',
        'nombre',
        'telefono',
        'correo',
        'cuenta_corriente',
        'pais',
        'moneda',
        'importe_c_mensual',

        // Agrega aquí otros campos si es necesario
    ];

    /**
     * Obtiene todos los clientes con un importe mensual mayor a 10.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function clientesConImporteMayorA10()
    {
        return $this->where('importe_c_mensual', '>', 10)->get();
    }

    /**
     * Obtiene el ID de un cliente por su CIF.
     *
     * @param string $cif El CIF del cliente
     * @return int|null
     */
    public static function obtenerIdPorCIF($cif)
    {
        $cliente = self::where('cif', $cif)->first();

        // Si se encuentra el cliente, devuelve su ID, de lo contrario, devuelve null
        return $cliente ? $cliente->id : null;
    }

    /**
     * Guarda un nuevo cliente en la base de datos.
     *
     * @param clienteRequest $request Los datos del cliente proporcionados por el formulario
     * @return Cliente
     */
    public static function guardarCliente(clienteRequest $request)
    {
        $cliente = new Cliente();

        $cliente->fill([
            'cif' => $request->cif,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'cuenta_corriente' => $request->cuenta_corriente,
            'pais' => $request->pais,
            'moneda' => $request->moneda,
            'importe_c_mensual' => $request->importe_c_mensual,
        ]);

        $cliente->save();

        return $cliente;
    }
    /**
     * Actualiza un cliente existente en la base de datos.
     *
     * @param int $id El ID del cliente
     * @param clienteRequest $request Los datos del cliente proporcionados por el formulario
     * @return \Illuminate\Http\JsonResponse
     */
    public function actualizarCliente($id, clienteRequest $request)
    {
        // Obtener la tarea por su ID
        $cliente = Cliente::find($id);
        echo ("id: " . $id);
        echo ("request ID:" . $request->id);

        // Verificar si la tarea existe
        if (!$cliente) {
            //echo($tarea->IDTarea);
            echo ("cliente no encontrado");
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }



        // Actualizar los atributos de la tarea con los datos del formulario
        $cliente->fill($request->all());


        echo ("antiguo: " . $cliente->nombre . " nuevo: " . $request->nombre);

        // Guardar los cambios en la base de datos
        $cliente->save();

        // Retornar una respuesta exitosa
        return response()->json(['mensaje' => 'Cliente actualizado correctamente'], 200);
    }
}
