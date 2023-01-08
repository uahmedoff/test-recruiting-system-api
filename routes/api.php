<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CvController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\VacancyController;
use App\Http\Controllers\Api\V1\PositionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::fallback(function(){
    return response()->json([
        'status' => 'error',
        'message' => 'Not found'
    ], 404);
});

Route::group(['prefix' => 'v1'],function(){
    Route::controller(AuthController::class)
        ->prefix('auth')
        ->group(function(){
            Route::post('login','login');
            Route::post('register','register');
            Route::get('me','me');
        });
    
    Route::group([
        'middleware' => 'auth:sanctum'
    ], function(){
        Route::apiResource('positions', PositionController::class);
        Route::get('vacancies/with_number_of_otkliks',[VacancyController::class,'vacancies_with_number_of_otkliks']);
        Route::apiResource('vacancies', VacancyController::class);
        Route::apiResource('cvs', CvController::class);
        Route::post('vacancies/otklik',[VacancyController::class,'otklik']);
        Route::get('cvs/{cv_id}/vacancies',[CvController::class,'vacancies_by_cv']);
        Route::get('vacancies/my/with_otkliks',[VacancyController::class,'my_vacancies_with_otkliks']);
        Route::get('cvs/made_last_week/with_number_of_otkliks',[CvController::class,'cvs_created_last_week_with_number_of_otkliks']);
    });
});