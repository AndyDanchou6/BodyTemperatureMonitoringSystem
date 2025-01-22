<?php

use App\Http\Controllers\StudentInfoController;
use App\Http\Controllers\TemperatureRecordsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('student_info')->group(function () {
    Route::post('/store', [StudentInfoController::class, 'store']);
    Route::get('/all', [StudentInfoController::class, 'index']);
    Route::get('/show/{id}', [StudentInfoController::class, 'show']);
    Route::put('/update', [StudentInfoController::class, 'update']);
});

Route::prefix('temperature_records')->group(function () {
    Route::post('/temp_reading', [TemperatureRecordsController::class, 'temperatureReading']);
    Route::post('/store', [TemperatureRecordsController::class, 'store']);
});

Route::post('/students/scan', [StudentInfoController::class, 'scan'])->name('scan');
