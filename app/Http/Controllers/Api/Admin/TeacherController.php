<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\TeacherCheckInRequest;
use App\Http\Resources\TeacherResource;
use App\Http\Requests\Teacher\TeacherStoreRequest;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::get();
        return response()->json(['data'=> TeacherResource::collection( $teachers ) ], 200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherStoreRequest $request)
    {
        $user=User::find($request->id)->update(['role_id'=>3]);
        $teacher = Teacher::create([
            'user_id' => $request->user_id,
            'creator_id'=> auth()->user()->id ,
            'date'=> Carbon::now()
        ]);
        return response()->json(['msg'=> $teacher->user->name .'has been promoted to teacher'], 200) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherCheckInRequest $request)
    {
        $teacher = Teacher::find($request->teacher_id);
        return response()->json([
            'message'=> "Successfull",
            'data'=> new TeacherResource( $teacher ) 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherCheckInRequest $request)
    {
        $teacher = Teacher::find($request->teacher_id);
        $user= $teacher->user->update(['role_id'=>5]);
        $teacher->delete();
        return response()->json(['msg'=>'Teacher unpromoted successfully'], 200) ;
    }
}
