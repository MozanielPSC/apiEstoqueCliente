<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignInRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_signIn()
    {
        $response = $this->post('/api/signIn', ["email" => "mozanielpcorrea@gmail.com","cnpj" => '64507895000138','terminal' => 'mozaniel']);

        $response
            ->assertStatus(200);
            //$response->dd();
            $response->dump();
    }
}
