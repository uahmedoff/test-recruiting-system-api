<?php
namespace App\Services;

use App\Models\Api\V1\Position;

class PositionService extends AppBaseService{
    
    public function __construct(){
        $this->model = Position::class;
    }

}
