<?php

use App\Http\Controllers\RentVehicleController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTripController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleTripController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResources([
    'users'    => UserController::class,
    'vehicles' => VehicleController::class,
]);

Route::apiResources([
    'trips'          => TripController::class,
    'users.trips'    => UserTripController::class,
    'vehicles.trips' => VehicleTripController::class,
], ['only' => ['index', 'show']]);

Route::get('/vehicles/{vehicle}/rent', [RentVehicleController::class, 'rent'])->name('vehicles.rent');
Route::get('/vehicles/{vehicle}/release', [RentVehicleController::class, 'release'])->name('vehicles.release');
