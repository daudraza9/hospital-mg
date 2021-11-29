<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function test_it_stores_new_user(){
        $response = $this->post('register', [
            'name '=>'david',
            'email'=>'david@gmail.com',
            'password'=>'12345678',
            'password_confirmation'=>'12345678'
        ]);

        $response->assertRedirect('/home');

    }
}
