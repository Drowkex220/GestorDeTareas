<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Usuario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'nombre_usuario' => $this->faker->userName,
            'contrasena' => bcrypt('password'), // Cambia 'password' por la contraseña que desees
            'permiso' => 'operario', // Por ejemplo, asignamos 'operario' como permiso predeterminado
        ];
    }
}
