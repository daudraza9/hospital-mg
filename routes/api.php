<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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
Route::post('/login', [ApiController::class, 'login'])->name('login');
Route::post('/register', [ApiController::class, 'register'])->name('register');

Route::middleware(['auth','api'])->group(function (){

});

Route::group(['prefix'=>'doctor','as'=>'doctor.'],function(){
    Route::post('/store', [ApiController::class, 'storeDoctor'])->name('storeDoctor');
    Route::get('/get', [ApiController::class, 'getDoctor'])->name('getDoctor');
    Route::post('/search/{id}', [ApiController::class, 'searchDoctor'])->name('searchDoctor');
    Route::post('/delete/{id}', [ApiController::class, 'deleteDoctor'])->name('deleteDoctor');
    Route::post('/update/{id}', [ApiController::class, 'update'])->name('update');
});
