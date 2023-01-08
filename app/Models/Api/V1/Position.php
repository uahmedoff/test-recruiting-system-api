<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Position extends Model{

    use Userstamps;

    public $table = 'positions';

    public $fillable = [
        'name'
    ];

    public static array $rules = [
        'name' => 'required'
    ];

    // set default updated_by userstamp null
    public function setUpdatedByAttribute($value) { 
        return null;
    }

    public function vacancies(){
        return $this->hasMany(Vacancy::class);
    }

}
