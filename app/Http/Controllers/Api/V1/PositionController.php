<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\User;
use Illuminate\Http\Request;
use App\Models\Api\V1\Position;
use App\Services\PositionService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Api\V1\PositionResource;
use App\Http\Requests\Api\V1\CreatePositionAPIRequest;
use App\Http\Requests\Api\V1\UpdatePositionAPIRequest;

class PositionController extends AppBaseController{
    
    protected $positionService;

    public function __construct(PositionService $positionService){
        parent::__construct();
        $this->positionService = $positionService;
    }

    public function index(Request $request): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_JOB_SEEKER]);
        $positions = $this->positionService->getData([
            'created_by' => $this->ifUserIsHirerOrJobSeekerThenOnesIdElseAll(User::ROLE_HIRER),
            'per_page' => $this->per_page
        ]);
        return $this->sendResponse(
            PositionResource::collection($positions)->response()->getData(true), 
            'Positions retrieved successfully'
        );            
    }

    public function store(CreatePositionAPIRequest $request): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_ADMIN,User::ROLE_JOB_SEEKER]);
        $position = Position::create([
            'name' => $request->name
        ]);
        return $this->sendResponse(new PositionResource($position), 'Position created successfully');
    }

    public function show($id): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_JOB_SEEKER]);
        $position = Position::findOrFail($id);
        $this->forbiddenIfNotCreator(User::ROLE_HIRER,$position->created_by);
        return $this->sendResponse(new PositionResource($position), 'Position retrieved successfully');
    }

    public function update($id, UpdatePositionAPIRequest $request): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_JOB_SEEKER,User::ROLE_ADMIN]);
        $position = Position::findOrFail($id);
        $this->forbiddenIfNotCreator(User::ROLE_HIRER,$position->created_by);
        $position->fill(['name'=>$request->name]);
        $position->save();
        return $this->sendResponse(new PositionResource($position), 'Position updated successfully');
    }

    public function destroy($id): JsonResponse{
        $this->forbiddenIfRole([User::ROLE_JOB_SEEKER]);
        $position = Position::findOrFail($id);
        $this->forbiddenIfNotCreator(User::ROLE_HIRER,$position->created_by);
        $position->delete();
        return $this->sendResponse("",'Position deleted successfully');
    }
}
