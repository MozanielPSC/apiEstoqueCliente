<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateEnterpriseEmpresasRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_updateEnterprise()
    {
        $response = $this->post('/api/empresas/update', ["cnpj" => "42591651000143", "email" => "example@email.com", "id" => "31"]);

        $response->assertStatus(200);

        $response->dump();
    }
}
