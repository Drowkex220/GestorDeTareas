<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Provincia
 *
 * Esta clase representa una provincia en el sistema.
 *
 * @package App\Models
 */

class Provincia extends Model
{
    /**
     * Nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'tbl_provincias';
    /**
     * Nombre de la clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'cod';
    /**
     * Indica si el modelo debe ser marcado con marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = false; // Suponemos que no tienes timestamps en esta tabla

      /**
     * Los atributos que son asignables.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'comunidad_id',
        'codigo_ine',
        // ... otras columnas
    ];

    // Relación con la comunidad

}
