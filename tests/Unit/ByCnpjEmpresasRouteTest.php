<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ByCnpjEmpresasRouteTest extends TestCase
{
    public function test_byCnpj()
    {
        $responseByCnpj = $this->post('/api/empresas/byCnpj', ["cnpj" => "00245274000140"]);

        $responseByCnpj->assertStatus(200);

        $responseByCnpj->dump();

    }
}
