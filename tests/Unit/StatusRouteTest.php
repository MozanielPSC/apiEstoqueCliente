<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatusRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_status_separacao()
    {
        $response = $this->post('/api/separacao/status', ["status" => "F", "codigo" => "35629", 'cnpj' => "31810224000192"]);

        $response->assertStatus(200);
        //$response->dd();
        $response->dump();

    }
}
