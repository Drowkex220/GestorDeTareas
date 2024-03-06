<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Usuario;
use App\Models\User;

use Illuminate\Support\Facades\Route;

class RouteTest extends TestCase
{
    /**
     * Test all routes to ensure they exist and return a valid response.
     *
     * @return void
     */

    public function testRoutes()
    {
        $user = Usuario::factory()->create();
        $this->actingAs($user);

        $routes = [
            '/listaTareas',
            '/listaCuotas',
            '/listaClientes',
            '/listaUsuarios',
            '/listaFiltrarTareas',
            '/loginForm',
            '/addUsuario',
            '/modCliente/1',
            '/modUsuario/1',
            '/modTareas/1',
            '/addCliente',

            '/addCuota',
            '/modCuota/1',
            '/addTareas',
            '/updTareas/1',
        ];



        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }
}
