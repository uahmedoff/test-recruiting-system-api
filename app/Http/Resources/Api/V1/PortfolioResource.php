<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource{
    public function toArray($request){
        return [
            'id' => $this->id,
            'file' => $this->file,
            'cv_id' => $this->cv_id
        ];
    }
}
