<?php
namespace App\Services;

class AppBaseService{

    protected $model;

    public function getData($filter = []){
        $query = $this->model::query();
        if(isset($filter['created_by']))
            $query->where('created_by',$filter['created_by']);
        $query = $query->with('creator')->latest('id');
        if(isset($filter['per_page']))
           $results = $query->paginate($filter['per_page']);
        else
            $results = $query->get();
        return $results;
    }

}
