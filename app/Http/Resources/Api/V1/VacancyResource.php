<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResource extends JsonResource{
    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => new PositionResource($this->position),
            'salary_from' => $this->salary_from,
            'salary_to' => $this->salary_to,
            'skills' => $this->skills,
            'job_procedure' => $this->job_procedure,
            'number_of_views' => $this->number_of_views,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => new UserResource($this->creator),
        ];
    }
}
