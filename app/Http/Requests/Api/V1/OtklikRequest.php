<?php

namespace App\Http\Requests\Api\V1;

class OtklikRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'cv_id' => 'required|integer',
            'vacancy_id' => 'required|integer'
        ];
    }
}
