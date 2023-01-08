<?php

namespace App\Http\Controllers;

use App\Models\Api\V1\User;
use App\Traits\ResponseAble;

class AppBaseController extends Controller{
    use ResponseAble;
    
    protected $per_page;
    protected $user;

    public function __construct(){
        $this->per_page = 25;
        $this->user = auth('sanctum')->user();
    }

    protected function forbiddenIfRole($roles){
        foreach($roles as $role){
            if($this->user->role == $role)
                return $this->sendError("","Forbidden",403);
        }
    }

    protected function forbiddenIfNotCreator($role,$created_by){
        if($this->user->role == $role && $created_by != $this->user->id)
            return $this->sendError("","Forbidden",403);
    }

    protected function ifUserIsHirerOrJobSeekerThenOnesIdElseAll($role){
        return ($this->user->role == $role) ? $this->user->id : null;
    }

}
