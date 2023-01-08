<?php

namespace App\Http\Requests\Api\V1;

class LoginRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
