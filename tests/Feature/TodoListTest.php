<?php

namespace Tests\Feature;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TodoListTest extends TestCase
{

    use RefreshDatabase;

    public function setup():void
    {
        parent::setUp();
        $user = $this->authUser();
        $this->list = $this->createTodoList([
            'name' => 'my list',
            'user_id' => $user->id
        ]);
    }
    
    public function test_fetch_all_todo_list()
    {

        // preparation / prepare
        // $list = 
        // TodoList::factory()->count(2)->create(['name'=>'my list']);
        // dd($list);
        
        // action / perform

        // dd(route('todo-list.store'));
        $this->createTodoList();
        $response = $this->getJson(route('todo-list.index'));
        // dd($response->json()[0]['name]);

        // assertion / predict

        $this->assertEquals(1,count($response->json()));
        $this->assertEquals('my list',$response->json()[0]['name']);
        
    }

    public function test_fetch_single_todo_list()
    {
        // $list = TodoList::factory()->create(['name'=>'my list']);
        $response = $this->getJson(route('todo-list.show',$this->list->id))
                    ->assertOk()
                    ->json();

        $this->assertEquals($response['name'], $this->list->name);
    }

    public function test_store_new_todo_list()
    {
        $list = TodoList::factory()->make();
        $response = $this->postJson(route('todo-list.store'),['name' => $list->name])
            ->assertCreated()
            ->json();
        // dd($response['name']);
        $this->assertEquals($list->name, $response['name']);
        $this->assertDatabaseHas('todo_lists', ['name' => $list->name]);
    }

    public function test_while_storing_todo_list_name_field_is_required(){
        $this->withExceptionHandling();
        $response = $this->postJson(route('todo-list.store'))
                    ->assertUnprocessable()
                    ->assertJsonValidationErrors(['name']);
        // dd($response);
    }

    public function test_delete_todo_list(){
        // dd($this->list->name);
        $this->deleteJson(route('todo-list.destroy', $this->list->id))
                ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', ['name' => $this->list->name]);
    }

    public function test_update_todo_list(){
        $this->patchJson(route('todo-list.update', $this->list->id),['name' => 'updated name'])
        ->assertOk();

        $this->assertDatabaseHas('todo_lists', ['id' => $this->list->id, 'name' => 'updated name']);
    }

    public function test_while_updating_todo_list_name_field_is_required(){
        $this->withExceptionHandling();
        $response = $this->patchJson(route('todo-list.update', $this->list->id))
                    ->assertUnprocessable()
                    ->assertJsonValidationErrors(['name']);
        // dd($response);
    }
}
