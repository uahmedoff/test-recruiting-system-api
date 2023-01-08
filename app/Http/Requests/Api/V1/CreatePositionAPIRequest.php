<?php

namespace App\Http\Requests\Api\V1;

use App\Models\Api\V1\Position;

class CreatePositionAPIRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return Position::$rules;
    }

}
