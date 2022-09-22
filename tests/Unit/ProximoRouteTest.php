<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProximoRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_proximo()
    {
        $response = $this->post('/api/separacao/proximo', ["cnpj" => "37724329000105", "codigoseparador" => "999"]);

        $response->assertStatus(200);
        //$response->dd();
        $response->dump();
    }
}
