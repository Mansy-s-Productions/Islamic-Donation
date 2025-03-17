<?php

use App\Http\Controllers\HadithController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\VolunteerPhotosController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('request.limit')->group(function () {
    Route::post('submit-design', [VolunteerPhotosController::class, 'submitDesign'])->name('submitDesign');
});

Route::get('/ayah/{lang}/{sura}/{ayah}', [QuranController::class, 'getAyahImage']);
Route::get('/hadith/{lang}/{hadith_id}', [HadithController::class, 'getHadithImage']);
