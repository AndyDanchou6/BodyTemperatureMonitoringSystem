<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentInfoController;
use App\Http\Controllers\TemperatureRecordsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [DashboardController::class, 'home'])->name('home')->middleware('auth');


Route::get('/login', [DashboardController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('/loginHandler', [AuthController::class, 'loginHandler'])->name('login.handler')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logoutHandler'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('students')->group(function () {
    Route::get('/index', [StudentInfoController::class, 'studentsIndex'])->name('students.index');
    Route::get('/create', [StudentInfoController::class, 'create'])->name('students.create');
    Route::get('/edit/{id}', [StudentInfoController::class, 'edit'])->name('students.edit');
    Route::post('/store', [StudentInfoController::class, 'store'])->name('students.store');
    Route::delete('/delete/{id}', [StudentInfoController::class, 'delete'])->name('students.delete');
    Route::put('/update/{id}', [StudentInfoController::class, 'update'])->name('students.update');
    Route::get('/tempRecords/{id}', [StudentInfoController::class, 'tempRecords'])->name('students.tempRecords');
    Route::delete('/delete/{id}', [StudentInfoController::class, 'TemperatureDestroy'])->name('temperature.delete');
});

Route::prefix('/temperature')->group(function () {
    Route::get('/index', [TemperatureRecordsController::class, 'index'])->name('temperature.index');
    Route::delete('/delete/{id}', [TemperatureRecordsController::class, 'destroy'])->name('temperature.destroy');
});
