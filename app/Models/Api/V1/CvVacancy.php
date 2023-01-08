<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Model;

class CvVacancy extends Model{

    // Disable default updated at timestamp
    public const UPDATED_AT = null;

    public $table = 'cv_vacancies';

    public $fillable = [
        'cv_id',
        'vacancy_id'
    ];

    public static array $rules = [
        'cv_id' => 'required',
        'vacancy_id' => 'required'
    ];

    public function vacancy(){
        return $this->belongsTo(Vacancy::class);
    }

    public function cv(){
        return $this->belongsTo(Cv::class);
    }
}
