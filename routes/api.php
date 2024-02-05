<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Models\Admin;

// Student routes

Route::post('/register', [StudentController::class, 'register']);

Route::post('/login', [StudentController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/registrations/{id}', [StudentController::class, 'getRegistration']);

    Route::post('/pay', [StudentController::class, 'pay']);

    Route::put('/verify/{id}', [StudentController::class, 'verifyPayment']);
});

// Admin routes

Route::post('/admin/login', [AdminController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/admin/add', [AdminController::class, 'addAdmin']);

    Route::post('/course/add', [AdminController::class, 'addCourse']);

    Route::get('/courses', [AdminController::class, 'getCourses']);

    Route::get('/admins', [AdminController::class, 'getAdmins']);

    Route::delete('/course/remove/{id}', [AdminController::class, 'removeCourse']);

    Route::get('/students', [AdminController::class, 'getStudents']);

    Route::get('/student/{id}', [AdminController::class, 'getStudentById']);
    
    Route::delete('/student/remove/{id}', [StudentController::class, 'destroy']);

    Route::get('/registrations', [AdminController::class, 'getRegistrations']);

    Route::get('/payments', [AdminController::class, 'getPayments']);

    Route::put('/registration/verify/{id}', [AdminController::class, 'verifyRegistration']);

    Route::put('/payment/verify/{id}', [AdminController::class, 'verifyPayment']);

    Route::delete('/admin/remove/{id}', [AdminController::class, 'removeAdmin']);
});

// chapa callback route

Route::get('callback/{reference}', 'App\Http\Controllers\ChapaController@callback')->name('callback');


