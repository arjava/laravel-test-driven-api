<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_a_user_can_register()
    {
        $this->postJson(route('user.register'),[
            'name'=>'Aom Rafly',
             'email'=>'aomrafly@gmail.com',
              'password'=>'1sbackwh3n',
              'password_confirmation' => '1sbackwh3n'])
        ->assertCreated();

        $this->assertDatabaseHas('users',['name' => 'Aom Rafly']);
    }
}
