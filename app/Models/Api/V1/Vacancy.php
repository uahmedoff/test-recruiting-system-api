<?php

namespace App\Models\Api\V1;

use Illuminate\Support\Facades\DB;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model{

    use Userstamps;

    public const STATUS_ACTIVE = 1;
    public const STATUS_ARCHIVED = 2;

    public $table = 'vacancies';

    public $fillable = [
        'name',
        'position_id',
        'salary_from',
        'salary_to',
        'skills',
        'job_procedure',
        'number_of_views',
        'status'
    ];

    protected $casts = [
        'skills' => 'array'
    ];

    public static array $create_rules = [
        'name' => 'required',
        'position_id' => 'required|integer',
        'salary_from' => 'required|numeric',
        'salary_to' => 'required|numeric',
        'skills' => 'required|array',
        'job_procedure' => 'required'
    ];

    public static array $update_rules = [
        'name' => 'nullable',
        'position_id' => 'nullable|integer',
        'salary_from' => 'nullable|numeric',
        'salary_to' => 'nullable|numeric',
        'skills' => 'nullable|array',
        'job_procedure' => 'nullable'
    ];

    public function get_vacancies_with_number_of_otkliks(){
        $query = "
            select 
                v.name as vacancy_name, 
                p.name as position_name, 
                u.email as created_by,
                count(o.*) as number_of_otkliks
            from ab_vacancies v
            left join ab_cv_vacancy o on v.id=o.vacancy_id
            left join ab_positions p on p.id=v.position_id
            left join ab_users u on u.id=v.created_by
            group by v.name, p.name, u.email
        ";
        return DB::select($query);
    }

    // set default updated_by userstamp null
    public function setUpdatedByAttribute($value) { 
        return null;
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function cvs(){
        return $this->belongsToMany(Cv::class)->withPivot('created_at');
    }
}
