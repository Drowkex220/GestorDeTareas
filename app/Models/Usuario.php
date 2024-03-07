<?php

namespace App\Models;

use App\Http\Requests\usuarioRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

/**
 * Clase Usuario
 *
 * Esta clase representa un usuario en el sistema.
 *
 * @package App\Models
 */
class Usuario extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasFactory;

    /**
     * Nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'usuariosgt';
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
    public $timestamps = false; // Suponemos que no tienes timestamps en esta tabla

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'nombre_usuario',
        'contrasena',
        'permiso',
        'last_session',
        // ... otras columnas
    ];


    /**
     * Los atributos que no son asignables en masa.
     *
     * @var array
     */

    protected $guarded = [
        'id',
        // Otros campos que no deseas permitir que se asignen en masa
    ];

    /**
     * Obtiene el nombre del identificador único para el usuario.
     *
     * @return string
     */
    public function username()
    {
        return 'nombre_usuario'; // Nombre del campo de usuario
    }

    /**
     * Obtiene la contraseña del usuario.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->contrasena; // Nombre del campo de contraseña
    }



    /**
     * Obtiene usuarios con permiso de operario.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerOperarios()
    {
        return $this->where('permiso', 'operario')->get();
    }
    /**
     * Guarda un nuevo usuario en la base de datos.
     *
     * @param usuarioRequest $request La solicitud de usuario
     * @return Usuario
     */
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
    /**
     * Actualiza un usuario existente en la base de datos.
     *
     * @param int $id El ID del usuario a actualizar
     * @param usuarioRequest $request La solicitud de actualización de usuario
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\Routing\ResponseFactory
     */
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
