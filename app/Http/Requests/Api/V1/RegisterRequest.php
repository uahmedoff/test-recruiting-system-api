<?php

namespace App\Http\Requests\Api\V1;

class RegisterRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|integer|in:1,2,3'
        ];
    }
}
