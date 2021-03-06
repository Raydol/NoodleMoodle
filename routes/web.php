<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserModuleController;
use App\Http\Controllers\AdviceController;

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
Route::get('/subjects/{email}', [SubjectController::class, 'userSubjects']);
Route::get('/subjectslist', [SubjectController::class, 'subjectslist']);

//Insert Subject
Route::get('/subject/new', [SubjectController::class, 'subjectForm']);
Route::post('/subject/new', [SubjectController::class, 'addSubject']);

//Insert Module
Route::get('/module/new', [ModuleController::class, 'moduleForm']);
Route::post('/module/new', [ModuleController::class, 'addModule']);

//Generate Activation Code
Route::get('/subject/new/generatecode', [SubjectController::class, 'generateCode']);

//Delete user
Route::post('/user/delete', [UserController::class, 'deleteUser']);

//Module details
Route::get('/module/{idModule}', [ModuleController::class, 'moduleDetails']);

//Join module
Route::get('/module/{idModule}/join', [UserModuleController::class, 'joinModule']);

//Leave module
Route::get('/module/{idModule}/leave', [UserModuleController::class, 'leaveModule']);

//Validate if a subject has a teacher
Route::post('/module/{nombreAsignatura}/validate', [SubjectController::class, 'validateSubject']);

//Join subject
Route::post('/module/{nombreAsignatura}/join', [SubjectController::class, 'processActivationCode']);

//Leave subject
Route::get('/module/{idModule}/subject/{idSubject}/leave', [SubjectController::class, 'leaveSubject']);

//Advices
Route::get('/advices', [AdviceController::class, 'advices']);
Route::post('/advice/request', [AdviceController::class, 'processRequest']);

//Delete module
Route::get('/module/{idModule}/delete', [ModuleController::class, 'deleteModule']);

//Delete subject
Route::post('/subject/delete', [SubjectController::class, 'deleteSubject']);

//Subject details or Subject details with temary
Route::post('/module/{idModule}/{subjectName}', [SubjectController::class, 'subjectDetails']);
Route::post('/module/{idModule}/{subjectName}/temary', [SubjectController::class, 'subjectDetails']);

//Subject participants
Route::post('/module/{idModule}/{subjectName}/participants', [SubjectController::class, 'subjectParticipants']);

//Load Files
Route::post('/module/{idModule}/{subjectName}/temary/load', [SubjectController::class, 'loadFile']);

//Delete Files
Route::post('/module/{idModule}/{subjectName}/temary/delete', [SubjectController::class, 'deleteFile']);
