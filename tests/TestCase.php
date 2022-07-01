<?php

namespace Tests;

use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void{
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createTodoList($args = []){
        return TodoList::factory()->create($args);
    }

    public function createTask($args = []){
        return Task::factory()->create($args);
    }

    public function createUser($args = []){
        return User::factory()->create($args);
    }

    public function authUser(){
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        return $user;
    }
}
