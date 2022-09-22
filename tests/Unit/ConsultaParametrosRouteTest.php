<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultaParametrosRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultaParametros()
    {
        $response = $this->post('/api/consultaParametros', ["cnpj" => "7890552036199"]);


        $response->assertStatus(200);

        $response->dump();
    }
}
