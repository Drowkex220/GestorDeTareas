<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;


class LoginTest extends TestCase
{
   /**
     * Test the login form is displayed correctly.
     *
     * @return void
     */
    public function testLoginFormIsDisplayed()
    {
        $response = $this->get('/loginForm');

        $response->assertStatus(200) // Verifica que se carga la página correctamente
            ->assertSee('Iniciar Sesión') // Verifica que la página contiene el título del formulario
            ->assertSee('Nombre de Usuario') // Verifica que la página contiene el campo "Nombre de Usuario"
            ->assertSee('Contraseña') // Verifica que la página contiene el campo "Contraseña"
            ->assertSee('Recordar credenciales') // Verifica que la página contiene la opción "Recordar credenciales"
            ->assertSee('Iniciar Sesión'); // Verifica que la página contiene el botón "Iniciar Sesión"
    }

    /**
     * Test the login form can be submitted with valid data.
     *
     * @return void
     */
    public function testLoginFormCanBeSubmittedWithValidData()
    {
        $response = $this->post('/authenticate', [
            'nombre_usuario' => 'julian',
            'password' => '123456',
        ]);

        $response->assertStatus(302); // Verifica que la redirección se realiza correctamente
        // Aquí puedes agregar más aserciones según sea necesario, por ejemplo, verificar si el usuario está autenticado después del inicio de sesión
    }
}
