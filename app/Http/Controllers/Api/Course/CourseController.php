<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Http\Requests\Course\CourseCheckInRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllOpenCourse()
    {
        $courses = Course::latest()->whereNotNull('registration_end_date')->get();
        return response()->json(['data'=> CourseResource::collection( $courses ) ], 200) ;
    }

    public function getAllActiveCourse()
    {
      //  $courses = Course::latest()->whereNull('registration_end_date')->get();
       // return response()->json(['data'=> CourseResource::collection( $courses ) ], 200) ;
    }

    public function getAllClosedCourse()
    {
       // $courses = Course::latest()->whereNull('registration_end_date')->get();
       // return response()->json(['data'=> CourseResource::collection( $courses ) ], 200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseStoreRequest $request)
    {
        $inputs = $request->all();
        $inputs['creator_id'] = auth()->user()->id;
        $course = Course::create($inputs);
        return response()->json(['msg'=>'course has been added'], 200) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseCheckInRequest $request)
    {
        $course = Course::find($request->course_id);        
        return response()->json([
            'message'=> "Successfull",
            'data'=> new CourseResource( $course ) 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request)
    {
        $course = Course::find($request->course_id);
        $updatedcourse = $course->update($request->all());
        return response()->json(['msg'=>'course has been updated'], 200) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCheckInRequest $request)
    {
        $course = Course::find($request->course_id)->delete();
        return response()->json(['msg'=>'course has been deleted'], 200) ;
    }
}
