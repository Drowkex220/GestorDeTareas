<?php

namespace App\Models;

use App\Http\Requests\usuarioRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasFactory;
    protected $table = 'usuariosgt';
    protected $primaryKey = 'id';
    public $timestamps = false; // Suponemos que no tienes timestamps en esta tabla

    protected $fillable = [
        'nombre',
        'nombre_usuario',
        'contrasena',
        'permiso',
        'last_session',
        // ... otras columnas
    ];



    protected $guarded = [
        'id',
        // Otros campos que no deseas permitir que se asignen en masa
    ];


    //AUTENTICACION//

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function username()
    {
        return 'nombre_usuario'; // Nombre del campo de usuario
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->contrasena; // Nombre del campo de contraseña
    }


    //GESTION//

    /**
     * Obtener usuarios con permiso de operario
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerOperarios()
    {
        return $this->where('permiso', 'operario')->get();
    }

    public static function guardarUsuario(usuarioRequest $request)
    {
        // Crea una nueva instancia del modelo Cliente con los datos proporcionados
        $usuario = new Usuario();

        $usuario->fill([
            'nombre' => $request->nombre,
            'nombre_usuario' => $request->nombre_usuario,
            'contrasena' => Hash::make($request->contrasena),
            'permiso' => $request->permiso,
        ]);

        // Guarda el cliente en la base de datos
        $usuario->save();

        // Devuelve el cliente creado
        return $usuario;
    }

    public function actualizarUsuario($id, usuarioRequest $request)
    {
        // Obtener la tarea por su ID
        $usuario = Usuario::find($id);
        echo ("id: " . $id);
        echo ("request ID:" . $request->id);

        // Verificar si la tarea existe
        if (!$usuario) {
            //echo($tarea->IDTarea);
            echo ("usuario no encontrado");
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }



        // Actualizar los atributos de la tarea con los datos del formulario
        $usuario->fill([
            'nombre' => $request->nombre,
            'nombre_usuario' => $request->nombre_usuario,
            'contrasena' => Hash::make($request->contrasena),
            'permiso' => $request->permiso,
        ]);


        echo ("antiguo: " . $usuario->nombre_usuario . " nuevo: " . $request->nombre_usuario);

        // Guardar los cambios en la base de datos
        $usuario->save();

        // Retornar una respuesta exitosa
        return response()->json(['mensaje' => 'Usuario actualizado correctamente'], 200);
    }
}
