<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiStudentController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::get('/usuariosAPI', [ApiStudentController::class, 'index']);
Route::post('/usuariosAPI', [ApiStudentController::class, 'store']);
Route::put('/usuariosAPI/{stud_id}', [ApiStudentController::class, 'update']);
Route::delete('/usuariosAPI/{stud_id}', [ApiStudentController::class, 'destroy']);
