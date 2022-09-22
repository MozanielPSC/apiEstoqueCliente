<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetornoprocessoRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_RetornoProcesso()
    {   
        
        $response = $this->post('/api/retornoprocesso', ["cnpj" => "7890552036199","tipoerp" => "teste", "coderp" => 0, "appcodigo" => 1
        ,"appinicioprocesso" => "06/06/2022 17:46", "appfinalprocesso" => "06/06/2022 17:47", "finalizacao" => "06/06/2022 17:47", "appcodfuncionario" => 3,
        "appsituacao" => "teste", "items" => [["sequencia" => 1, "codproduto" => "23", "quantidade" => "5.0", "separado" =>"5.0", "conferido" => "5.0",
        "falta" => "5.0", "preco" => "876", "desconto" => "23.0", "descricao_item" => "HSCONCORDE IMAGEM 23"] , ["sequencia" => 2, "codproduto" => "24"
        , "quantidade" => "32.0", "separado" => "32.0", "conferido" => "32.0", "falta" => "32.0", "preco" => "876", "desconto" => "24.0",
        "descricao_item" =>"HSCONCORDE IMAGEM 24"]]]);
        

        $response
            ->assertStatus(200);
            //$response->dd();
            $response->dump();
    }
}
