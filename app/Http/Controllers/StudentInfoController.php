<?php

namespace App\Http\Controllers;

use App\Models\Student_info;
use App\Models\Temperature_records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class StudentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function studentsIndex()
    {
        $students = Student_info::orderBy('created_at', 'desc')->get();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

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
    // public function store(Request $request)
    // {
    //     try {
    //         $studentInfoValidation = Validator::make($request->all(), [
    //             'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //             'student_id' => 'nullable|string',
    //             'name' => 'required|string',
    //             'course' => 'required|string',
    //             'year_level' => 'required|numeric',
    //         ]);

    //         if ($studentInfoValidation->fails()) {
    //             return response()->json([
    //                 'message' => 'Student Info not valid!',
    //             ], 400);
    //         }

    //         $newStudentInfo = new Student_info();

    //         $newStudentInfo->student_id = $request->input('student_id');
    //         $newStudentInfo->name = $request->input('name');
    //         $newStudentInfo->course = $request->input('course');
    //         $newStudentInfo->year_level = $request->input('year_level');

    //         if ($request->hasFile('avatar')) {
    //             $avatarPath = $request->file('avatar')->store('avatar', 'public');
    //             $newStudentInfo->avatar = $avatarPath;
    //         }

    //         if (!$newStudentInfo->save()) {
    //             return response()->json([
    //                 'message' => 'Failed to add new student info',
    //             ], 500);
    //         }

    //         return response()->json([
    //             'message' => 'Student info added successfully',
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'message' => $th->getMessage(),
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
    {
        try {
            $studentInfoValidation = Validator::make($request->all(), [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'student_id' => 'string',
                'name' => 'required|string',
                'course' => 'required|string',
                'year_level' => 'required|numeric',
            ]);

            if ($studentInfoValidation->fails()) {
                return redirect()->back()->withInput()->withErrors($studentInfoValidation);
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
                return redirect()->back()->with('error', 'Failed to add new student info');
            }

            return redirect()->route('students.index')->with('success', 'Student Record Successfully Registered');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete(string $id)
    {
        $students = Student_info::find($id);

        $students->delete();

        return redirect()->route('students.index')->with('success', 'Student Record Successfully Deleted');
    }

    public function TemperatureDestroy(string $id)
    {
        $temperatureID = Temperature_records::findOrFail($id);

        $temperatureID->delete();

        return redirect()->route('students.index')->with('success', 'Temperature Successfully Deleted');
    }

    public function scan(Request $request)
    {
        try {
            $rfidTag = $request->input('student_id');

            $existingStudent = Student_info::where('student_id', $rfidTag)->first();

            if ($existingStudent) {
                return response()->json([
                    'message' => 'RFID Card is already registered.',
                    'status' => 409,
                ], 409);
            }

            if ($rfidTag) {
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    [
                        'cluster' => env('PUSHER_APP_CLUSTER'),
                        'useTLS' => true,
                    ]
                );

                $pusher->trigger('rfid-scanner_channel', 'rfid-scanned', [
                    'message' => 'RFID Card Scanned Successfully!',
                    'status' => 200,
                    'data' => $rfidTag,
                ]);

                return response()->json([
                    'message' => 'RFID Card Scanned Successfully!',
                    'data' => $rfidTag,
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

                $pusher->trigger('rfid-scanner_channel', 'rfid-scanned', [
                    'status' => 404,
                    'message' => 'Invalid RFID tag',
                ]);

                return response()->json([
                    'message' => 'Invalid RFID tag',
                ], 404);
            }
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

                $pusher->trigger('idSensor_channel', 'id-detected', [
                    'message' => 'Id detected. Student Found',
                    'status' => 200,
                    'data' => $student_info,
                ]);

                $pusher->trigger('new-user', 'create-new-user', [
                    'message' => 'Id already used. Scan another RFID',
                    'status' => 409,
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

                $pusher->trigger('idSensor_channel', 'id-detected', [
                    'status' => 404,
                    'message' => 'RFID Card Not Registered!',
                ]);

                $pusher->trigger('new-user', 'create-new-user', [
                    'message' => 'Id usable. Id can be used to create user',
                    'status' => 200,
                    'data' => $student_id,
                ]);

                return response()->json([
                    'message' => 'RFID Card Not Registered!',
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
    public function edit(string $id)
    {
        $students = Student_info::find($id);

        return view('students.edit', compact('students'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request)
    // {
    //     try {
    //         if (!$request->has('student_id')) {
    //             return response()->json([
    //                 'message' => 'Provide the student id',
    //             ], 400);
    //         }

    //         $studentInfoValidation = Validator::make($request->all(), [
    //             'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //             'student_id' => 'nullable|string',
    //             'name' => 'nullable|string',
    //             'course' => 'nullable|string',
    //             'year_level' => 'nullable|numeric',
    //         ]);

    //         if ($studentInfoValidation->fails()) {
    //             return response()->json([
    //                 'message' => 'Student Info not valid!',
    //             ], 400);
    //         }

    //         $toUpdateInfo = Student_info::where('student_id', $request->student_id)
    //             ->first();

    //         $updated = $toUpdateInfo->update($request->all());

    //         if ($request->hasFile('avatar')) {
    //             $avatarPath = $request->file('avatar')->store('avatar', 'public');
    //             $toUpdateInfo->avatar = $avatarPath;
    //         }

    //         if (!$updated) {
    //             return response()->json([
    //                 'message' => 'Failed to add new student info',
    //             ], 500);
    //         }

    //         return response()->json([
    //             'message' => 'Student info updated successfully',
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'message' => $th->getMessage(),
    //         ], 500);
    //     }
    // }

    public function update(Request $request, String $id)
    {
        $request->validate([
            'student_id' => 'string',
            'name' => 'required|string',
            'course' => 'required|string',
            'year_level' => 'required|numeric',
        ]);

        $students = Student_info::find($id);

        $students->student_id = $request->input('student_id');
        $students->name = $request->input('name');
        $students->course = $request->input('course');
        $students->year_level = $request->input('year_level');

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatar', 'public');
            $students->avatar = $avatarPath;
        }

        $students->save();

        return redirect()->route('students.index')->with('success', 'Student Record Successfully Updated');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function tempRecords(string $id)
    {
        $studentTempRecords = Student_info::where('student_id', $id)->with('temperatureRecords')->first();

        // dd($studentTempRecords);
        return view('students.tempRecords', compact('studentTempRecords'));
    }
}
