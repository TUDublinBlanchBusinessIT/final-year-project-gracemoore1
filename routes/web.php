<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;

// Landlord controllers
use App\Http\Controllers\Auth\LandlordRegisterController;
use App\Http\Controllers\Auth\LandlordCodeVerificationController; 
use App\Http\Controllers\Auth\LandlordOCRController;

// Student controllers
use App\Http\Controllers\StudentRegisterController;
use App\Http\Controllers\StudentPasswordResetController;

// Breeze / Laravel User Controllers
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\AuthController;
//admin controller
use App\Http\Controllers\AdminDashboardController;


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

Route::post('/landlord/resend-code', [LandlordCodeVerificationController::class, 'resend'])
    ->name('landlord.verify.email.resend');




Route::get('/', function () {
    return view('welcome');
});



Route::get('/student/register', [StudentRegisterController::class, 'showForm']);
Route::post('/student/register', [StudentRegisterController::class, 'register']);

Route::get('/student/verify-email', [StudentRegisterController::class, 'showVerify']);
Route::post('/student/verify-email', [StudentRegisterController::class, 'verifyEmail']);

Route::get('/student/verify-id', [StudentRegisterController::class, 'showVerifyId']);
Route::post('/student/verify-id', [StudentRegisterController::class, 'verifyId']);

Route::get('/home', [StudentRegisterController::class, 'dashboard'])
    ->name('student.dashboard');




Route::get('/student/forgot-password', [StudentPasswordResetController::class, 'showForgot'])
    ->name('student.password.request');

Route::post('/student/forgot-password', [StudentPasswordResetController::class, 'sendResetLink'])
    ->name('student.password.email');

Route::get('/student/reset-password/{token}', [StudentPasswordResetController::class, 'showResetForm'])
    ->name('student.password.reset');

Route::post('/student/reset-password', [StudentPasswordResetController::class, 'resetPassword'])
    ->name('student.password.update');




Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

require __DIR__.'/auth.php';




Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');




Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

//admin
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/reports', function () {
    return view('admin.reports');
})->name('admin.reports');

Route::get('/admin/accounts', function () {
    return view('admin.accounts');
})->name('admin.accounts');

Route::get('/admin/partnerships', function () {
    return view('admin.partnerships');
})->name('admin.partnerships');

Route::get('/admin/chatbot', function () {
    return view('admin.chatbot');
})->name('admin.chatbot');

Route::get('/dashboard', function () {
    // Admin
    if (session('role') === 'admin' || session('admin_id')) {
        return redirect()->route('admin.dashboard');
    }
    // Student
    if (session('student_id')) {
        return redirect()->route('student.dashboard');
    }
    // Not logged in
    return redirect()->route('login');
    })->name('dashboard');

    Route::post('/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('logout');

Route::post('/admin/partnerships', [App\Http\Controllers\PartnershipController::class, 'store'])->name('admin.partnerships.store');

Route::get('/serviceprovider/dashboard', function () {
    return view('serviceprovider.dashboard');
})->name('serviceprovider.dashboard');
