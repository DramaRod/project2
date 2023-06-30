<?php

use App\Http\Controllers\Api\Admin\ModeratorController;
use App\Http\Controllers\Api\Admin\StudentController;
use App\Http\Controllers\Api\Admin\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login']);
Route::get('user/verify', [UserController::class, 'verifyEmail'])->name('mail.verify');

Route::middleware('auth:api')->group(function () {

    Route::group(['prefix' => 'admin'], function(){
        
        Route::group(['prefix' => 'moderator'], function(){
            Route::get('index',[ ModeratorController::class , 'index']);
            Route::get('show/{moderator_id}',[ ModeratorController::class , 'show']);
            Route::post('store',[ ModeratorController::class , 'store']);
            Route::get('{moderator_id}/delete',[ ModeratorController::class , 'destroy']);
        });

        Route::group(['prefix' => 'teacher'], function(){
            Route::get('index',[ TeacherController::class , 'index']);
            Route::get('show/{teacher_id}',[ TeacherController::class , 'show']);
            Route::post('store',[ TeacherController::class , 'store']);
            Route::get('{teacher_id}/delete',[ TeacherController::class , 'destroy']);
        });

        Route::group(['prefix' => 'student'], function(){
            Route::get('index',[ StudentController::class , 'index']);
            Route::get('show/{student_id}',[ StudentController::class , 'show']);
            Route::post('store',[ StudentController::class , 'store']);
            Route::get('{teacher_id}/delete',[ StudentController::class , 'destroy']);
        });
    });

    Route::group(['prefix' => 'courses'], function(){
        Route::get('index',[ CourseController::class , 'index']);
        Route::get('show/{course_id}',[ CourseController::class , 'show']);
        Route::post('store',[ CourseController::class , 'store']);
        Route::post('{course_id}/update',[ CourseController::class , 'update']);

        Route::group(['prefix' => '{course_id}/levels'], function(){
            Route::get('index',[ LevelController::class , 'index']);
            Route::get('show/{level_id}',[ LevelController::class , 'show']);
            Route::post('store',[ LevelController::class , 'store']);
            Route::post('{level_id}/update',[ LevelController::class , 'update']);
            Route::get('{level_id}/delete',[ LevelController::class , 'destroy']);

            Route::group(['prefix' => '{level_id}/subject'], function(){
                Route::get('index',[ SubjectController::class , 'index']);
                Route::get('show/{subject_id}',[ SubjectController::class , 'show']);
                Route::post('store',[ SubjectController::class , 'store']);
                Route::post('{subject_id}/update',[ SubjectController::class , 'update']);
                Route::get('{subject_id}/delete',[ SubjectController::class , 'destroy']);
            });
            
        });
    });

});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
