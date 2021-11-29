<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public function testExample (){
             $this->assertTrue(true);
    }

    public function test_it_stores_new_user(){
        $response = $this->post('register', [
            'name '=>'david',
            'email'=>'david@gmail.com',
            'password'=>'12345678',
            'password_confirmation'=>'12345678'
        ]);

        $response->assertRedirect(route('home'));
    }

}
