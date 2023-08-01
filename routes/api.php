<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\CidadeMedicoController;
use App\Http\Controllers\MedicoPacienteController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\AuthController ;

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

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
});

/**
 * Users
 */

Route::resource('user', 'App\Http\Controllers\UserController', ['only' => ['store']]);


/**
 * Cidades Routes
 */
Route::resource('cidades', CidadeController::class, ['only' => ['index']]);

Route::resource('cidade.medicos', CidadeMedicoController::class, ['only' => ['index']]);


/**
 * Medico Routes
 */

Route::resource('medicos', MedicoController::class, ['only' => ['index','store']]);


Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('medicos.paciente', MedicoPacienteController::class,  ['only' => ['index','store']]);
});

/**
 * Paciente routes
 */


Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('pacientes', PacienteController::class,  ['only' => ['index','store','update']]);
});



