<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ByCodeProductsRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_byCode()
    {
        $response = $this->post('/api/products/byCode', ['cnpj' => '42591651000143', 'code' => '1']);

        $response->assertStatus(200);

        $response->dump();
       // ->assertJson([
         //   'created' => true,
        //]);
    }
}
