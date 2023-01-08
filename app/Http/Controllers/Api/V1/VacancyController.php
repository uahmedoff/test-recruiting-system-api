<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\User;
use Illuminate\Http\Request;
use App\Models\Api\V1\Vacancy;
use App\Services\VacancyService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Api\V1\OtklikRequest;
use App\Http\Resources\Api\V1\VacancyResource;
use App\Http\Requests\Api\V1\VacanciesByCVRequest;
use App\Http\Requests\Api\V1\CreateVacancyAPIRequest;
use App\Http\Requests\Api\V1\UpdateVacancyAPIRequest;
use App\Http\Resources\Api\V1\VacanciesWithOtkliksResource;

class VacancyController extends AppBaseController{
    
    protected $vacancyService;

    public function __construct(VacancyService $vacancyService){
        parent::__construct();
        $this->vacancyService = $vacancyService;
    }

    public function index(Request $request): JsonResponse{
        $vacancies = $this->vacancyService->getData([
            'created_by' => $this->ifUserIsHirerOrJobSeekerThenOnesIdElseAll(User::ROLE_HIRER),
            'per_page' => $this->per_page
        ]);
        return $this->sendResponse(
            VacancyResource::collection($vacancies)->response()->getData(true), 
            'Vacancies retrieved successfully'
        );            
    }

    public function store(CreateVacancyAPIRequest $request): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_ADMIN,User::ROLE_JOB_SEEKER]);   
        $vacancy = Vacancy::create([
            'name' => $request->name,
            'position_id' => $request->position_id,
            'salary_from' => $request->salary_from,
            'salary_to' => $request->salary_to,
            'skills' => $request->skills,
            'job_procedure' => $request->job_procedure
        ]);
        return $this->sendResponse(new VacancyResource($vacancy), 'Vacancy saved successfully');
    }

    public function show($id): JsonResponse{
        $vacancy = Vacancy::findOrFail($id);
        if($this->user->role == User::ROLE_JOB_SEEKER){
            $vacancy->number_of_views++;
            $vacancy->save();
        }
        return $this->sendResponse(new VacancyResource($vacancy), 'Vacancy retrieved successfully');
    }

    public function update($id, UpdateVacancyAPIRequest $request): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_JOB_SEEKER,User::ROLE_ADMIN]);
        $vacancy = Vacancy::findOrFail($id);
        $this->forbiddenIfNotCreator(User::ROLE_HIRER,$vacancy->created_by);
        if($request->has('name'))
            $vacancy->name = $request->name;
        if($request->has('position_id'))
            $vacancy->position_id = $request->position_id;
        if($request->has('salary_from'))
            $vacancy->salary_from = $request->salary_from;
        if($request->has('salary_to'))
            $vacancy->salary_to = $request->salary_to;
        if($request->has('skills'))
            $vacancy->skills = $request->skills;
        if($request->has('job_procedure'))
            $vacancy->job_procedure = $request->job_procedure;    
        $vacancy->save();
        return $this->sendResponse(new VacancyResource($vacancy), 'Vacancy updated successfully');
    }

    public function destroy($id): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_JOB_SEEKER]);
        $vacancy = Vacancy::findOrFail($id);
        $this->forbiddenIfNotCreator(User::ROLE_HIRER,$vacancy->created_by);
        $vacancy->delete();
        return $this->sendResponse("",'Vacancy deleted successfully');
    }

    public function otklik(OtklikRequest $request){
        $this->forbiddenIfRole([User::ROLE_ADMIN,User::ROLE_HIRER]);
        $cv = $this->user->cvs()->findOrFail($request->cv_id);
        $otklik = $cv->vacancies()->attach($request->vacancy_id,['created_at'=>now()]);
        return $this->sendResponse("",'Vacancy responded successfully');
    }

    public function my_vacancies_with_otkliks(){
        $this->forbiddenIfRole([User::ROLE_JOB_SEEKER]);
        $vacancies_with_otkliks = $this->user->vacancies()->with('cvs')->get();
        return $this->sendResponse(
            VacanciesWithOtkliksResource::collection($vacancies_with_otkliks)->response()->getData(true),
            "Vacancies with otkliks retrieved successfully"
        );
    }

    public function vacancies_with_number_of_otkliks(Vacancy $vacancy){
        $this->forbiddenIfRole([User::ROLE_JOB_SEEKER,User::ROLE_HIRER]);
        return $this->sendResponse(
            $vacancy->get_vacancies_with_number_of_otkliks(),
            "Vacancies with number of otkliks retrieved successfully"
        );
    }
}
