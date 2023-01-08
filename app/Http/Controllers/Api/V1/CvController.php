<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\Cv;
use App\Models\Api\V1\User;
use App\Services\CvService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Api\V1\CvResource;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Api\V1\VacancyResource;
use App\Http\Requests\Api\V1\CreateCvAPIRequest;
use App\Http\Requests\Api\V1\UpdateCvAPIRequest;

class CvController extends AppBaseController{

    protected $cvService;

    public function __construct(CvService $cvService){
        parent::__construct();
        $this->cvService = $cvService;
    }

    public function index(Request $request): JsonResponse{
        $cvs = $this->cvService->getData([
            'created_by' => $this->ifUserIsHirerOrJobSeekerThenOnesIdElseAll(User::ROLE_JOB_SEEKER),
            'per_page' => $this->per_page
        ]);
        return $this->sendResponse(
            CvResource::collection($cvs)->response()->getData(true), 
            'Cvs retrieved successfully'
        );
    }

    public function store(CreateCvAPIRequest $request){
        $this->forbiddenIfRole([User::ROLE_ADMIN,User::ROLE_HIRER]);   
        $cv = $this->cvService->createCV($request,$this->user);
        return $this->sendResponse(new CvResource($cv), 'Cv created successfully');
    }

    public function show($id): JsonResponse{
        $cv = Cv::findOrFail($id);
        return $this->sendResponse(new CvResource($cv), 'Cv retrieved successfully');
    }

    public function update($id, UpdateCvAPIRequest $request): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_HIRER,User::ROLE_ADMIN]);
        $cv = Cv::findOrFail($id);
        $this->forbiddenIfNotCreator(User::ROLE_JOB_SEEKER,$cv->created_by);
        $updated_cv = $this->cvService->updateCV($cv,$request,$this->user);
        return $this->sendResponse(new CvResource($updated_cv), 'Cv updated successfully');
    }

    public function destroy($id): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_HIRER]);
        $cv = Cv::findOrFail($id);
        $this->forbiddenIfNotCreator(User::ROLE_JOB_SEEKER,$cv->created_by);
        $cv->delete();
        return $this->sendResponse("",'Cv deleted successfully');
    }

    public function vacancies_by_cv(int $cv_id){
        $this->forbiddenIfRole([User::ROLE_HIRER]);
        $cv = $this->user->cvs()->findOrFail($cv_id);
        $vacancies = $cv->vacancies;
        return $this->sendResponse(
            VacancyResource::collection($vacancies)->response()->getData(true), 
            'Vacancies retrieved successfully'
        );
    }

    public function cvs_created_last_week_with_number_of_otkliks(Cv $cv){
        $this->forbiddenIfRole([User::ROLE_JOB_SEEKER,User::ROLE_HIRER]);
        return $this->sendResponse(
            $cv->get_cvs_created_last_week_with_number_of_otkliks(),
            "Cvs which was created last week with number of otkliks retrieved successfully"
        );
    }
}
