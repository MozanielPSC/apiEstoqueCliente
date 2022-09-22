<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create()
    {
        $response = $this->postJson('/api/pedidos/create', ["cnpj" => "31810224000192"], ["json" => ["teste" => "teste"]]);

        $response->assertStatus(200);
        
        $response->dump();
    }
}
