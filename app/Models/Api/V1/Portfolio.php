<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model{

    public $table = 'portfolios';

    public $timestamps = false;

    public $fillable = [
        'file',
        'cv_id'
    ];

    public static array $rules = [
        'file' => 'required',
        'cv_id' => 'required'
    ];

    public function cv(){
        return $this->belongsTo(Cv::class);
    }
}
