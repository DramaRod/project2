<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Level;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Http\Requests\Level\LevelStoreRequest;
use App\Http\Requests\Level\LevelUpdateRequest;
use App\Http\Requests\Level\LevelCheckInRequest;
use App\Http\Requests\Course\CourseCheckInRequest;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CourseCheckInRequest $request)
    {
        $course = Course::find($request->course_id);
        $levels = $course->levels;
        return response()->json([
            'message'=> "Successfull",
            'data'=> LevelResource::collection( $levels ) 
        ]);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LevelStoreRequest $request)
    {
        $newLevel = Level::create( $request->all() );
        return response()->json(['msg'=>'level has been added'], 200) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(LevelCheckInRequest $request)
    {
        $level = Level::find($request->level_id);        
        return response()->json([
            'message'=> "Successfull",
            'data'=> new LevelResource( $level ) 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LevelUpdateRequest $request)
    {
        $level = Level::find($request->level_id);
        $updatedlevel = $level->update($request->all());
        return response()->json(['msg'=>'level has been updated'], 200) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LevelCheckInRequest $request)
    {
        $level = Level::find($request->level_id)->delete();
        return response()->json(['msg'=>'level has been deleted'], 200) ;
    }
}
