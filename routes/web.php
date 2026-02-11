<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LandlordRegisterController;
use App\Http\Controllers\Auth\LandlordCodeVerificationController; 
use App\Http\Controllers\Auth\LandlordOCRController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\PasswordController;





Route::get('/landlord/register', [LandlordRegisterController::class, 'create'])
    ->name('landlord.register.show');

Route::post('/landlord/register', [LandlordRegisterController::class, 'store'])
    ->name('landlord.register.store');


Route::get('/landlord/verify-email', function () {
    return view('landlord.verify-email');
})->name('landlord.verify.email');

Route::post('/landlord/verify-email', [LandlordCodeVerificationController::class, 'verify'])
    ->name('landlord.verify.email.submit');

Route::get('/landlord/verify-id', function (Request $request) {
    return view('landlord.verify-id', ['email' => $request->email]);
})->name('landlord.verify.id');


Route::post('/landlord/verify-id', [LandlordOCRController::class, 'verify'])
    ->name('landlord.verify.id.submit');



Route::get('/', function () {
    return view('welcome');
});

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->name('verification.notice');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::post('/landlord/resend-code', [LandlordCodeVerificationController::class, 'resend'])
    ->name('landlord.verify.email.resend');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);




});

require __DIR__.'/auth.php';

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');


Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');


Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');


Route::post('/reset-password', [PasswordController::class, 'store'])
    ->name('password.update');
