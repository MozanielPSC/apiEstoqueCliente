<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateEnterpriseEmpresasRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_createEnterprise()
    {
        $response = $this->get('/api/empresas/create', ["cnpj" => "42591651000143", "email" => "example@email.com", "password" => "147"]);

        $response->assertStatus(200);

        $response->dump();
    }
}
