<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\API\IncidentController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BarangayController;
use App\Http\Controllers\API\ChartController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\TypeController;
use App\Http\Controllers\API\IncidentCauseController;

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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group( function() {

    Route::post('logout', [RegisterController::class, 'logout']);

    Route::get('checkstatus', [RegisterController::class, 'check']);
    Route::put('updateaccount/{user}', [RegisterController::class, 'updateaccount']);
    Route::put('changepassword/{user}', [RegisterController::class, 'changepassword']);
    Route::get('mydetails', [RegisterController::class, 'mydetails']);

    Route::apiResource('users', UserController::class);
    Route::put('activate/{user}', [UserController::class, 'activate']);
    Route::put('deactivate/{user}', [UserController::class, 'deactivate']);

    Route::apiResource('incidents', IncidentController::class);
    Route::put('incident/updatestatus/{incident}', [IncidentController::class, 'updatestatus']);
    Route::put('incident/viewed/{incident}', [IncidentController::class, 'viewed']);
    Route::put('incident/accept/{incident}', [IncidentController::class, 'accept']);
    Route::get('incident/patients', [IncidentController::class, 'getpatients']);

    Route::apiResource('barangay', BarangayController::class)->only(['index', 'store', 'destroy']);
    Route::apiResource('types', TypeController::class)->only(['index', 'store', 'destroy']);
    Route::delete('deletetypes/{type}', [TypeController::class, 'deleteitem']);
    Route::apiResource('incident_causes', IncidentCauseController::class)->only(['index', 'store', 'destroy']);
    Route::get('indexbytype/{type}', [IncidentCauseController::class, 'indexbytype']);

    //cahrting
    Route::get('chart/accidents',[ChartController::class, 'accidenttypechart']);
    Route::get('chart/reportdata',[ChartController::class, 'incidentchart']);
    Route::get('chart/barangay',[ChartController::class, 'barangaychart']);

    Route::get('notifications',[NotificationController::class, 'index']);
    Route::get('notifications/get20',[NotificationController::class, 'get20']);

});