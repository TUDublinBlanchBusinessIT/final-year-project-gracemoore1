<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// routes/web.php
use App\Http\Controllers\StudentRegisterController;

Route::get('/student/register', [StudentRegisterController::class, 'showForm']);
Route::post('/student/register', [StudentRegisterController::class, 'register']);

Route::get('/student/verify-email', [StudentRegisterController::class, 'showVerify']);
Route::post('/student/verify-email', [StudentRegisterController::class, 'verifyEmail']);

Route::get('/student/verify-id', [StudentRegisterController::class, 'showVerifyId']);
Route::post('/student/verify-id', [StudentRegisterController::class, 'verifyId']);


// Dashboard
Route::get('/home', [StudentRegisterController::class, 'dashboard'])->name('student.dashboard');
