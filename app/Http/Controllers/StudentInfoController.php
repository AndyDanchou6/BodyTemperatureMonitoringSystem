<?php

namespace App\Http\Controllers;

use App\Models\Student_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class StudentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $allStudentInfo = Student_info::get();

            if (empty($allStudentInfo)) {
                return response()->json([
                    'message' => 'No student info found',
                ], 404)->header('Content-Type', 'application/json; charset=UTF-8');
            }

            return response()->json([
                'message' => 'Student info found',
                'data' => $allStudentInfo,
            ], 200)->header('Content-Type', 'application/json; charset=UTF-8');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500)->header('Content-Type', 'application/json; charset=UTF-8');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create(Request $request)
    // {
    //     return response()->json([
    //         'message' => 'test',
    //         'request' => $request->student_id,
    //     ], 200);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $studentInfoValidation = Validator::make($request->all(), [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'student_id' => 'nullable|string',
                'name' => 'required|string',
                'course' => 'required|string',
                'year_level' => 'required|numeric',
            ]);

            if ($studentInfoValidation->fails()) {
                return response()->json([
                    'message' => 'Student Info not valid!',
                ], 400);
            }

            $newStudentInfo = new Student_info();

            $newStudentInfo->student_id = $request->input('student_id');
            $newStudentInfo->name = $request->input('name');
            $newStudentInfo->course = $request->input('course');
            $newStudentInfo->year_level = $request->input('year_level');

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatar', 'public');
                $newStudentInfo->avatar = $avatarPath;
            }

            if (!$newStudentInfo->save()) {
                return response()->json([
                    'message' => 'Failed to add new student info',
                ], 500);
            }

            return response()->json([
                'message' => 'Student info added successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $student_id)
    {
        try {
            $student_info = Student_info::where('student_id', $student_id)
                ->first();

            if ($student_info) {
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    [
                        'cluster' => env('PUSHER_APP_CLUSTER'),
                        'useTLS' => true,
                    ]
                );

                $pusher->trigger('idSensor_channel', 'idSensor_channel', [
                    'message' => 'Id detected. Student Found',
                    'status' => 200,
                    'data' => $student_info,
                ]);

                return response()->json([
                    'message' => 'User Found',
                    'data' => $student_info,
                ], 200);
            } else {
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    [
                        'cluster' => env('PUSHER_APP_CLUSTER'),
                        'useTLS' => true,
                    ]
                );

                $pusher->trigger('idSensor_channel', 'idSensor_channel', [
                    'status' => 404,
                    'message' => 'Id not recognized!',
                ]);

                return response()->json([
                    'message' => 'ID not recognized!',
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student_info $student_info)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            if (!$request->has('student_id')) {
                return response()->json([
                    'message' => 'Provide the student id',
                ], 400);
            }

            $studentInfoValidation = Validator::make($request->all(), [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'student_id' => 'nullable|string',
                'name' => 'nullable|string',
                'course' => 'nullable|string',
                'year_level' => 'nullable|numeric',
            ]);

            if ($studentInfoValidation->fails()) {
                return response()->json([
                    'message' => 'Student Info not valid!',
                ], 400);
            }

            $toUpdateInfo = Student_info::where('student_id', $request->student_id)
                ->first();

            $updated = $toUpdateInfo->update($request->all());

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatar', 'public');
                $toUpdateInfo->avatar = $avatarPath;
            }

            if (!$updated) {
                return response()->json([
                    'message' => 'Failed to add new student info',
                ], 500);
            }

            return response()->json([
                'message' => 'Student info updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student_info $student_info)
    {
        //
    }
}
