<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
use App\Models\Listing;
use App\Http\Controllers\Landlord\LandlordRentalController;
use App\Http\Controllers\PartnershipController;

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

Route::middleware(['landlord'])
    ->prefix('landlord')
    ->name('landlord.')
    ->group(function () {

        Route::get('/dashboard', fn () => view('landlord.dashboard'))->name('dashboard');

        Route::get('/rentals', [LandlordRentalController::class, 'index'])->name('rentals.index');
        Route::get('/rentals/create', [LandlordRentalController::class, 'create'])->name('rentals.create');
        Route::post('/rentals', [LandlordRentalController::class, 'store'])->name('rentals.store');
        Route::get('/rentals/{rental}/edit', [LandlordRentalController::class, 'edit'])->name('rentals.edit');
        Route::put('/rentals/{rental}', [LandlordRentalController::class, 'update'])->name('rentals.update');
        Route::delete('/rentals/{rental}', [LandlordRentalController::class, 'destroy'])->name('rentals.destroy');
    });


Route::middleware(['landlord'])->group(function () {
    Route::get('/landlord/messages', fn () => view('landlord.messages'))->name('messages');
    Route::get('/landlord/support', fn () => view('landlord.support'))->name('landlord.support');
});

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


// STUDENT LOGIN
Route::get('/student/login', function() {
    return view('auth.login');
})->name('student.login.form');

Route::post('/student/login', [AuthenticatedSessionController::class, 'storeStudent'])
    ->name('student.login');

Route::get('/student/forgot-password', [StudentPasswordResetController::class, 'showForgot'])
    ->name('student.password.request');

Route::post('/student/forgot-password', [StudentPasswordResetController::class, 'sendResetLink'])
    ->name('student.password.email');

Route::get('/student/reset-password/{token}', [StudentPasswordResetController::class, 'showResetForm'])
    ->name('student.password.reset');

Route::post('/student/reset-password', [StudentPasswordResetController::class, 'resetPassword'])
    ->name('student.password.update');

Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->name('verification.notice');

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

// ADMIN ACCOUNT MANAGEMENT ROUTES
Route::prefix('admin/accounts')->group(function () {

    // Default → Students tab
    Route::get('/', fn() => redirect()->route('admin.accounts.students'))
        ->name('admin.accounts');

    // Students
    Route::get('/students', function () {
        $students = \App\Models\Student::all();
        return view('admin.student-accounts', compact('students'));
    })->name('admin.accounts.students');

    // Landlords
    Route::get('/landlords', function () {
        $landlords = \App\Models\Landlord::all();
        return view('admin.landlord-accounts', compact('landlords'));
    })->name('admin.accounts.landlords');

    // Service Providers
    Route::get('/service-providers', function () {
        $providers = \App\Models\ServiceProvider::all();
        return view('admin.serviceprovider-accounts', compact('providers'));
    })->name('admin.accounts.serviceproviders');

});

Route::get('/admin/accounts', function () {
    return view('admin.accounts');
})->name('admin.accounts');

Route::get('/admin/partnerships', function () {
    return view('admin.partnerships');
})->name('admin.partnerships');

Route::get('/admin/chatbot', function () {
    return view('admin.chatbot');
})->name('admin.chatbot');

Route::get('/admin/profile', function () {
    return view('admin.profile');
})->name('admin.profile');


Route::get('/dashboard', function () {
    // Admin (your custom session)
    if (session('role') === 'admin' || session('admin_id')) {
        return redirect()->route('admin.dashboard');
    }

    // Student (your custom session)
    if (session('student_id')) {
        return redirect()->route('student.dashboard');
    }

    // Breeze-authenticated user (normal user / landlord / service provider)
    if (Auth::check()) {
        return view('landlord.dashboard');
    }

    // Not logged in at all
    return redirect()->route('login');
    })->name('dashboard');

    Route::post('/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('logout');


Route::post('/admin/partnerships', [App\Http\Controllers\PartnershipController::class, 'store'])->name('admin.partnerships.store');






Route::get('/student/messages', function () {
    if (!session('student_id')) return redirect('/student/login');
    return view('student.messages');
})->name('student.messages');

Route::get('/student/support', function () {
    if (!session('student_id')) return redirect('/student/login');
    
   return view('student.support');
})->name('student.support');

// ===============================
// STUDENT: VIEW A SINGLE LISTING
// ===============================
Route::get('/listing/{id}', [App\Http\Controllers\StudentRegisterController::class, 'showListing'])
    ->name('listing.show');

// STUDENT PROFILE (ADD-ONLY, SAFE)
Route::prefix('student/profile-new')->group(function () {

    Route::get('/', [StudentRegisterController::class, 'studentProfile'])
        ->name('student.profile.new');

    Route::get('/applications', [StudentRegisterController::class, 'studentProfileApplications'])
        ->name('student.profile.new.applications');

    Route::get('/account', [StudentRegisterController::class, 'studentProfileAccount'])
        ->name('student.profile.new.account');

    Route::post('/reset-password', [StudentRegisterController::class, 'studentResetPassword'])
        ->name('student.profile.new.resetpassword');

    Route::post('/delete-account', [StudentRegisterController::class, 'studentDeleteAccount'])
        ->name('student.profile.new.delete');
});


/* ===========================
   SERVICE PROVIDER ROUTES
   =========================== */

Route::get('/serviceprovider/dashboard', function () {
    if (!session('serviceprovider_id')) return redirect('/login');
    return redirect()->route('serviceprovider.upcoming');
})->name('serviceprovider.dashboard');

Route::get('/serviceprovider/upcoming', function () {
    if (!session('serviceprovider_id')) return redirect('/login');
    return view('serviceprovider.upcoming');
})->name('serviceprovider.upcoming');

Route::get('/serviceprovider/completed', function () {
    if (!session('serviceprovider_id')) return redirect('/login');
    return view('serviceprovider.completed');
})->name('serviceprovider.completed');

Route::get('/serviceprovider/requested', function () {
    if (!session('serviceprovider_id')) return redirect('/login');
    return view('serviceprovider.requested');
})->name('serviceprovider.requested');

Route::get('/serviceprovider/messages', function () {
    if (!session('serviceprovider_id')) return redirect('/login');
    return view('serviceprovider.messages');
})->name('serviceprovider.messages');

Route::get('/serviceprovider/profile', function () {
    if (!session('serviceprovider_id')) return redirect('/login');
    return view('serviceprovider.profile');
})->name('serviceprovider.profile');