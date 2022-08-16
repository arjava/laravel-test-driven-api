<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        // $user = User::where(['email' => $request->email])->first();
        $user = User::whereEmail($request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response(['message'=>'Credentials not match.','status'=>0], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('api');

        return response([
            'status' => 1,
            'message' => 'Success',
            'token' => response(['token' => $token->plainTextToken])
        ]);
    }
}
