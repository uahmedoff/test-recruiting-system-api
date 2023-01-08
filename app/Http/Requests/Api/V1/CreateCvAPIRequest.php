<?php

namespace App\Http\Requests\Api\V1;

use App\Models\Api\V1\Cv;

class CreateCvAPIRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return Cv::$create_rules;
    }
}
