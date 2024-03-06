<?php

namespace App\Models;

use App\Http\Requests\clienteRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $primaryKey = 'id';

    public $timestamps = false;

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

    public function clientesConImporteMayorA10()
    {
        return $this->where('importe_c_mensual', '>', 10)->get();
    }

    public static function obtenerIdPorCIF($cif)
    {
        $cliente = self::where('cif', $cif)->first();

        // Si se encuentra el cliente, devuelve su ID, de lo contrario, devuelve null
        return $cliente ? $cliente->id : null;
    }

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
