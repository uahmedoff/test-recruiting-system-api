<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\User;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Requests\Api\V1\RegisterRequest;

class AuthController extends AppBaseController{

    public function register(RegisterRequest $request){
        $user = User::register($request);
        return $this->sendResponse(
            new UserResource($user),
            "User successfully registered"
        );
    }

    public function login(LoginRequest $request){
        $credentials = request(['email','password']);
        $user = User::where('email',$request->email)->first();
        if(!auth()->attempt($credentials)){
            return $this->unauthenticated();
        }
        return $this->sendResponse(
            [
                'access_token' => $user->createToken('auth-token')->plainTextToken
            ],
            "User successfully authenticated"
        );
    }

    protected function unauthenticated(){
        return $this->sendError(
            [
                'password' => [
                    'Invalid credentials'
                ]
            ],
            'The given data was invalid',
            422
        );
    }

    public function me(){
        $user = auth('sanctum')->user();
        return $this->sendResponse(new UserResource($user));
    }

}
