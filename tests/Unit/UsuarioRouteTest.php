<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsuarioRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_usuario()
    {
        $response = $this->post('/api/usuario', ["cnpj" => "37724329000106"]);

        $response->assertStatus(200);

        $response->dump();
    }
}
