<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'tbl_provincias';
    protected $primaryKey = 'cod';
    public $timestamps = false; // Suponemos que no tienes timestamps en esta tabla

    protected $fillable = [
        'nombre',
        'comunidad_id',
        'codigo_ine',
        // ... otras columnas
    ];

    // Relación con la comunidad

}
