<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index()
    {
        // $list = TodoList::whereUserId(auth()->id())->get();
        $list = auth()->user()->todo_lists;
        return response($list);
    }

    public function show(TodoList $todo_list)
    {
        // $list = TodoList::findOrFail($todolist);
        return response($todo_list);
    }

    public function store(TodoListRequest $request){
        // $store = TodoList::created(['name' => 'my list']);
        // $request->validate(['name'=>['required']]);
        // $list = 
        // $request['user_id'] = auth()->id();
        // return TodoList::create($request->all());
        // return response($list, Response::HTTP_CREATED);
        // return $list;
        return auth()->user()
                ->todo_lists()
                ->create($request->validated());
    }

    public function destroy(TodoList $todo_list){
        $todo_list->delete();
        return response('',Response::HTTP_NO_CONTENT);
    }

    public function update(TodoListRequest $request, TodoList $todo_list){
        // $request->validate(['name' => ['required']]);
        $todo_list->update($request->all());
        return response($todo_list);
    }
}
