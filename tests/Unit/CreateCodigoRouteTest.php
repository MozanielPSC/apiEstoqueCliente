<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCodigoRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_createCodigo()
    {
        $response = $this->post('/api/codigo/create', ['cnpj' => 42591651000144, 'cod_id_cnpj' => 9, 'cod_chave_terminal' => 9, 'cod_identificador' => 9, 'cod_localizacao' => 9,
        'cod_codigo' => 9, 'cod_preco' => 9, 'cod_quantidade' => 9]);

        $response->assertStatus(200);

        $response->dump();
        //$response->dd();
        /*->assertJson([
            'created' => true,
        ]); */
    }
}