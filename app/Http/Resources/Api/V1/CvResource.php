<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CvResource extends JsonResource{
    public function toArray($request){
        $resource = [
            'id' => $this->id,
            'positions' => $this->positions,
            'avatar' => $this->avatar,
            'work_experience' => $this->work_experience,
            'languages' => $this->languages,
            'desired_salary' => $this->desired_salary,
            'skills' => $this->skills,
            'portfolios' => PortfolioResource::collection($this->portfolios),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

        if(isset($this->pivot))
            $resource['otkliked_at'] = $this->pivot->created_at;

        return $resource;
    }
}
