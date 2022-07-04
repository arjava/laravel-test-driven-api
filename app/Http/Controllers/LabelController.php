<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Models\Label;

class LabelController extends Controller
{
    public function store(LabelRequest $request){
        // $request->validate(['title' => ['required'], 'color' => ['required']]);
        return Label::create($request->validated());
    }
}
