<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CadastroCodigoRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_cadastroCodigo()
    {
        $response = $this->post('/api/codigo/cadastro', ['cnpj' => 42591651000144, 'items' => ['cod_id_cnpj' => 7,
        'cod_chave_terminal' => 7,
        'cod_identificador' => 7,
        'cod_localizacao' => 7,
        'cod_codigo' => 7,
        'cod_preco' => 7,
        'cod_quantidade' => 7],
        ['cod_id_cnpj' => 8,
        'cod_chave_terminal' => 8,
        'cod_identificador' => 8,
        'cod_localizacao' => 8,
        'cod_codigo' => 8,
        'cod_preco' => 8,
        'cod_quantidade' => 8]]);

        $response->assertStatus(200);

        $response->dump();
        /*->assertJson([
            'created' => true,
        ]); */
    }
}
