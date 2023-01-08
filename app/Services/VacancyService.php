<?php
namespace App\Services;

use App\Models\Api\V1\Vacancy;

class VacancyService extends AppBaseService{
    
    public function __construct(){
        $this->model = Vacancy::class;
    }

}
