<?php
namespace App\Services;

use App\Models\Api\V1\Cv;
use Illuminate\Support\Facades\DB;

class CvService extends AppBaseService{
    
    public function __construct(){
        $this->model = Cv::class;
    }

    public function createCV($data,$user){
        $upload_folder = 'user_'.$user->id;
        DB::beginTransaction();
        try {
            $cv = $this->model::create([
                'positions' => $data->positions,
                'avatar' => FileService::createFromBase64($data->avatar,$upload_folder),
                'work_experience' => $data->work_experience,
                'languages' => $data->languages,
                'desired_salary' => $data->desired_salary,
                'skills' => $data->skills
            ]);
            foreach($data->portfolios as $portfolio){
                $cv->portfolios()->create([
                    'file' => FileService::createFromBase64($portfolio,$upload_folder)
                ]);
            }
            DB::commit();
            return $cv;
        } 
        catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function updateCV($cv,$data,$user){
        $upload_folder = 'user_'.$user->id;
        DB::beginTransaction();
        try {
            if(isset($data->positions))
                $cv->positions = $data->positions;
            if(isset($data->avatar))
                $cv->avatar = FileService::createFromBase64($data->avatar,$upload_folder);
            if(isset($data->work_experience))
                $cv->work_experience = $data->work_experience;
            if(isset($data->languages))
                $cv->languages = $data->languages;
            if(isset($data->desired_salary))
                $cv->desired_salary = $data->desired_salary;
            if(isset($data->positions))
                $cv->skills = $data->skills;
            $cv->save();
            if(count($data->portfolios)){
                $cv->portfolios()->delete();
                foreach($data->portfolios as $portfolio){
                    $cv->portfolios()->create([
                        'file' => FileService::createFromBase64($portfolio,$upload_folder)
                    ]);
                }
            }
            DB::commit();
            return $cv;
        } 
        catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}
