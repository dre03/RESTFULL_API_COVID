<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Raw;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//membuat santum grup
Route::middleware(['auth:sanctum'])->group(function(){
    //Route untuk menampilakan seluruh data
    Route::get('/patients', [PatientController::class, 'index']);
    //Route untuk menambahkan data
    Route::post('/patients', [PatientController::class, 'store']);
    //Route untuk melihat detail data
    Route::get('/patients/{id}', [PatientController::class, 'show']);
    //Route untuk update data
    Route::put('/patients/{id}', [PatientController::class, 'update']);
    //Route untuk menghapus data
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
    //Route untuk menampilkan data nama yang di cari
    Route::get('/patients/search/{name}', [PatientController::class, 'search']);
    //Route untuk menampilkan data yang positif
    Route::get('/patients/status/positive', [PatientController::class, 'positive']);
    //Route untuk menampilkan data yang Recoverde / sembuh
    Route::get('/patients/status/recovered', [PatientController::class, 'recovered']);
    //Route untuk menampilkan data yang dead / meninggal
    Route::get('/patients/status/dead', [PatientController::class, 'dead']); 
});
// Route untuk rigister dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);