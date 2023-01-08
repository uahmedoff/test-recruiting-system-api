<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest as FR;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Traits\ResponseAble;

class FormRequest extends FR{

    use ResponseAble;
    
    protected function failedValidation(Validator $validator){
        $errors = (new ValidationException($validator))->errors();
        return $this->sendError(
            $errors,
            'Validation error',
            422
        );
    }

}