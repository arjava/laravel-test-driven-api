<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index()
    {
        $list = TodoList::all();
        return response($list);
    }

    public function show(TodoList $list)
    {
        // $list = TodoList::findOrFail($todolist);
        return response($list);
    }

    public function store(Request $request){
        // $store = TodoList::created(['name' => 'my list']);
        $request->validate(['name'=>['required']]);
        // $list = 
        return TodoList::create($request->all());
        // return response($list, Response::HTTP_CREATED);
        // return $list;
    }

    public function destroy(TodoList $list){
        $list->delete();
        return response('',Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request, TodoList $list){
        $request->validate(['name' => ['required']]);
        $list->update($request->all());
        return response($list);
    }
}
