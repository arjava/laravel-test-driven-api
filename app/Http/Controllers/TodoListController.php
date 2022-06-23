<?php

namespace App\Http\Controllers;

class TodoListController extends Controller
{
    public function index()
    {
        return response(['list'=>[]]);
    }
}
