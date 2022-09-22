<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ByKeyTerminalRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_byKeyTerminal()
    {
        $response = $this->get('/api/terminal/byKey/1', ['cnpj' => '31810224000192']);

        $response->assertStatus(200);

        $response->dump();
    }
}
