<?php

namespace App\Models\Api\V1;

use Illuminate\Support\Facades\DB;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model{

    use Userstamps;

    public $table = 'cvs';

    public $fillable = [
        'positions',
        'avatar',
        'work_experience',
        'languages',
        'desired_salary',
        'skills'
    ];

    protected $casts = [
        'positions' => 'array',
        'languages' => 'array',
        'skills' => 'array'
    ];

    public static array $create_rules = [
        'positions' => 'required|array',
        'avatar' => 'nullable',
        'work_experience' => 'required|integer',
        'languages' => 'required|array',
        'desired_salary' => 'required|numeric',
        'skills' => 'required',
        'portfolios' => 'nullable|array'
    ];

    public static array $update_rules = [
        'positions' => 'nullable|array',
        'avatar' => 'nullable',
        'work_experience' => 'nullable|integer',
        'languages' => 'nullable|array',
        'desired_salary' => 'nullable|numeric',
        'skills' => 'nullable',
        'portfolios' => 'nullable|array'
    ];

    public function get_cvs_created_last_week_with_number_of_otkliks(){
        $query = "
            select 
                cv.id as cv_id,
                u.email as created_by,  
                count(o.*) as number_of_otkliks
            from ab_cvs cv
            left join ab_cv_vacancy o on cv.id=o.cv_id
            left join ab_users u on u.id=cv.created_by
            where cv.created_at between (now() - interval '1 week') and now()
            group by cv.id, u.email
        ";
        return DB::select($query);
    }

    // set default updated_by userstamp null
    public function setUpdatedByAttribute($value) { 
        return null;
    }

    public function portfolios(){
        return $this->hasMany(Portfolio::class);
    }

    public function vacancies(){
        return $this->belongsToMany(Vacancy::class);
    }
}
