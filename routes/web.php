<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [RestController::class, 'index'])->name('rest.index')->middleware('auth');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/', function () {
    return view('index');
});

require __DIR__.'/auth.php';
Route::get('/', [AttendanceController::class, 'index'])->middleware('auth');
Route::post('/', [AttendanceController::class, 'index'])->middleware('auth');
Route::post('/workStart', [AttendanceController::class, 'workStart']);

Route::post('/workEnd', [AttendanceController::class, 'workEnd']);
Route::post('/restStart', [AttendanceController::class, 'restStart']);
Route::post('/restEnd', [AttendanceController::class, 'restEnd']);
