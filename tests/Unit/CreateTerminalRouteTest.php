<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTerminalRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/api/terminal/create', ['terminal' => 'test-device-example', 'chave' => 'd1e2b175c467cf56cc1204a47d90d318', 'cnpj' => '61524301000109']);

        $response->assertStatus(200);

        $response->dump();
    }
}
