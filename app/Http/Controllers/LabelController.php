<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Http\Resources\LabelResource;
use App\Models\Label;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends Controller
{
    public function index(){
        $labels = auth()->user()->labels;
        return LabelResource::collection($labels);
    }

    public function store(LabelRequest $request){
        // $request->validate(['title' => ['required'], 'color' => ['required']]);
        // return Label::create($request->validated());
        $label = auth()->user()->labels()->create($request->validated());
        return new LabelResource($label);
    }

    public function destroy(Label $label){
        $label->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(LabelRequest $request, Label $label){
        $label->update($request->validated());
        // return response($label,Response::HTTP_OK);
        return new LabelResource($label);
    }
}
