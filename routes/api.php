<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;

// Student routes

Route::post('/register', [StudentController::class, 'register']);

Route::post('/login', [StudentController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/registrations/{id}', [StudentController::class, 'getRegistration']);
});

// Admin routes

Route::post('/course/add', [AdminController::class, 'addCourse']);