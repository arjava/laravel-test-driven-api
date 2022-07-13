<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\WebServiceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoListController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    route::apiResource('todo-list', TodoListController::class);

    route::apiResource('todo-list.task', TaskController::class)
    ->except('show')
    ->shallow();

    route::apiResource('label', LabelController::class);

    route::get('/web-service/connect/{name}', [WebServiceController::class, 'connect'])
    ->name('web-service.connect');

    route::post('/web-service/callback', [WebServiceController::class, 'callback'])
    ->name('web-service.callback');

    route::post('/web-service/{web_service}', [WebServiceController::class, 'store'])
    ->name('web-service.store');
});

Route::post('/register', RegisterController::class)
->name('user.register');

Route::post('/login', LoginController::class)
->name('user.login');
// Route::get('task', [TaskController::class, 'index'])
// ->name('task.index');

// Route::post('task', [TaskController::class, 'store'])
// ->name('task.store');

// Route::delete('task/{task}', [TaskController::class, 'destroy'])
// ->name('task.destroy');

// Route::get('todo-list',[TodoListController::class, 'index'])
// ->name('todo-list.index');

// Route::get('todo-list/{list}',[TodoListController::class, 'show'])
// ->name('todo-list.show');

// Route::post('todo-list',[TodoListController::class, 'store'])
// ->name('todo-list.store');

// Route::delete('todo-list/{list}',[TodoListController::class, 'destroy'])
// ->name('todo-list.destroy');

// Route::patch('todo-list/{list}', [TodoListController::class, 'update'])
// ->name('todo-list.update');
