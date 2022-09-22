<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowCodigoRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_showCodigo()
    {
        $response = $this->post('/api/codigo/show/3', ["cnpj" => "42591651000143"]);

        $response->assertStatus(200);
        //$response->dd();
        $response->dump();
    }
}
