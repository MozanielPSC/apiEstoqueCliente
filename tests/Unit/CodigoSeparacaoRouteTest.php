<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CodigoSeparacaoRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_codigoSeparacao()
    {
        $response = $this->post('/api/separacao/codigo/35630', ["cnpj" => "31810224000192"]);

        $response->assertStatus(200);

        $response->dump();
    }
}
