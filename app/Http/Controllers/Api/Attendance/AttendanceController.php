<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Student_attendance;
use App\Models\Teacher_attendance;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentCheckInRequest;

class AttendanceController extends Controller
{

    public function markStudentAttendance(StudentCheckInRequest $request)
    {
        $student = Student::find($request->student_id);
        $attendance = Student_attendance::create([
            'student_id' => $request->student_id,
            'date' => $request->date,
            'status' => true,
        ]);
        $teacher = Teacher::find(auth()->user()->id); // Assuming teacher is authenticated
        $date = $request->date;
        $existingAttendance = Teacher_attendance::where('teacher_id', $teacher->id)
        ->where('subject_id', $date)
        ->where('date', $date)
        ->first();
        if (!$existingAttendance) {
            Teacher_attendance::create([
                'user_id' => $teacher->id,
                'date' => $date,
                'status' => true, // Assuming teacher's attendance is always marked as 'present'
            ]);
        }
    



    }
    /**
     * Display a listing of the resource.
     */
    public function index2()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
