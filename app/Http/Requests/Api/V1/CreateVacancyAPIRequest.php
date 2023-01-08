<?php

namespace App\Http\Requests\Api\V1;

use App\Models\Api\V1\Vacancy;

class CreateVacancyAPIRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return Vacancy::$create_rules;
    }

}
