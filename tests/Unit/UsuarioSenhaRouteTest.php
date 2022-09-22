<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsuarioSenhaRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_usuarioSenha()
    {
        $response = $this->get('/api/usuarioSenha', ['cnpj' => '37724329000107', 'codigo' => '147', 'senha' => '147']);

        $response->assertStatus(200);

        $response->dump();
    }
}
