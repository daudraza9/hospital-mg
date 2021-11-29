<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginCase()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

//    public function testUserDuplication(){
//        $user1= User::make([
//           'name'=>'Daud Raza',
//            'email'=>'daud@gmail.com'
//        ]);
//        $user2= User::make([
//            'name'=>'Raza',
//            'email'=>'raza@gmail.com'
//        ]);
//        $this->assertTrue($user1->name != $user2->name);
//    }
//
//    public function test_delete_user(){
//        $user = User::factory()->count(1)->make();
//        $user = User::first();
//
//        if($user){
//            $user->delete();
//        }
//
//        $this->assertTrue(true);
//    }

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
