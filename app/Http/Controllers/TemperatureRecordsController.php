<?php

namespace App\Http\Controllers;

use App\Models\Temperature_records;
use Illuminate\Http\Request;
use Pusher\Pusher;

class TemperatureRecordsController extends Controller
{
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
    public function show(Temperature_records $temperature_records)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Temperature_records $temperature_records)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Temperature_records $temperature_records)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Temperature_records $temperature_records)
    {
        //
    }

    public function temperatureReading(Request $request) {
        try {
            $tempReading = $request->input('temperature');

            if ($tempReading) {
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    [
                        'cluster' => env('PUSHER_APP_CLUSTER'),
                        'useTLS' => true,
                    ]
                );

                $pusher->trigger('temp_reading_channel', 'temp_reading_channel', [
                    'message' => 'Temperature reading received',
                    'status' => 200,
                    'data' => $tempReading,
                ]);

                return response()->json([
                    'message' => 'Temperature reading received',
                    'data' => $tempReading,
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

                $pusher->trigger('temp_reading_channel', 'temp_reading_channel', [
                    'status' => 404,
                    'message' => 'No temperature reading!',
                ]);

                return response()->json([
                    'message' => 'No temperature reading!',
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
