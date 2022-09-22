<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ByDescProductsRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_byDesc()
    {
        $response = $this->post('/api/products/byDesc', ["desc" => "prod", "cnpj" => "42591651000143"]);

        $response->assertStatus(200);

        $response->dump();
    }
}
