<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\ModuleController;

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

session_start(); //Creamos una sesión de usuario, tanto si está logueado como si no

//Control Views

Route::get('/', [ViewController::class, 'showView']);

//Login

Route::get('/login', [UserController::class, 'login']);
Route::post('/login', [UserController::class, 'processLogin']);

//Logout

Route::get('/logout', [UserController::class, 'logout']);


//Registry

Route::get('/register', [UserController::class, 'register']);
Route::post('/register', [UserController::class, 'processRegistration']);

//Profile

Route::get('/profile/{email}', [UserController::class, 'profile']);

//Modules

Route::get('/modules', [ModuleController::class, 'modules']);
Route::get('/modules/{email}', [ModuleController::class, 'userModules']);

Route::get('/moduleslist', [ModuleController::class, 'moduleslist']);
Route::post('/moduleslist', [ModuleController::class, 'moduleslist']);

//Users

Route::get('/userslist', [UserController::class, 'users']);
Route::post('/userslist', [UserController::class, 'users']);

//Subjects


