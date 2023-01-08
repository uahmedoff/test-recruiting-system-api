<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'email' => $this->email,
            'role' => $this->role
        ];
    }

}
