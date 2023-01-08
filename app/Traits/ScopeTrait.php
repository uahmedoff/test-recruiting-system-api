<?php
namespace App\Traits;

trait ScopeTrait{

    public function scopeSort($query){
        return $query->orderBy(request()->get('column', 'id'), request()->get('order', 'asc'));
    }

    public function scopeSearch($query, $string){
        $columns = $this->search_columns;
        return $query->where(function ($query) use($string, $columns) {
            foreach ($columns as $column){
                //$query->orwhere($column, 'like',  '%' . $string .'%');
                $query->orwhere($column, 'ilike',  '%' . $string .'%');
            }
        });
    }

}
