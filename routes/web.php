<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\ProfileController;

//chatbot
use App\Http\Controllers\ChatbotController;

// Landlord controllers
use App\Http\Controllers\Auth\LandlordRegisterController;
use App\Http\Controllers\Auth\LandlordCodeVerificationController; 
use App\Http\Controllers\Auth\LandlordOCRController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\LandlordMessageController;
use App\Http\Controllers\Landlord\LandlordMaintenanceController;


// Student controllers
use App\Http\Controllers\StudentRegisterController;
use App\Http\Controllers\StudentPasswordResetController;
//student messaging
use App\Http\Controllers\StudentMessageController;
//student maintenance log
use App\Http\Controllers\Student\StudentMaintenanceController;

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

//service provider
use App\Http\Controllers\LandlordServiceRequestController;
use App\Http\Controllers\ServiceProviderRequestedJobsController;
use App\Http\Controllers\ServiceProviderMessageController;
use App\Http\Controllers\ServiceProviderUpcomingJobsController;

//chatbot
Route::get('/student/chatbot', [ChatbotController::class, 'studentChat'])->name('student.chatbot');
Route::get('/landlord/chatbot', [ChatbotController::class, 'landlordChat'])->name('landlord.chatbot');
Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');

//landlord/serviceprovider messaging
Route::middleware(['landlord'])->group(function () {
    Route::get('/landlord/maintenance/{id}/book-service-provider', [LandlordServiceRequestController::class, 'create'])
        ->name('landlord.service-request.create');

    Route::post('/landlord/maintenance/{id}/book-service-provider', [LandlordServiceRequestController::class, 'store'])
        ->name('landlord.service-request.store');
});

//sp
Route::middleware(['serviceprovider'])->group(function () {
    Route::get('/serviceprovider/requested', [ServiceProviderRequestedJobsController::class, 'index'])
        ->name('serviceprovider.requested');

    Route::post('/serviceprovider/requested/{id}/accept', [ServiceProviderRequestedJobsController::class, 'accept'])
        ->name('serviceprovider.requested.accept');

    Route::post('/serviceprovider/requested/{id}/decline', [ServiceProviderRequestedJobsController::class, 'decline'])
        ->name('serviceprovider.requested.decline');
});




Route::get('/landlord/register', [LandlordRegisterController::class, 'create'])
    ->name('landlord.register.show');

Route::post('/landlord/register', [LandlordRegisterController::class, 'store'])
    ->name('landlord.register.store');

Route::get('/landlord/verify-email', function (Request $request) {
    return view('landlord.verify-email', ['email' => $request->email]);
})->name('landlord.verify.email');  

//Route::get('/landlord/verify-email', function () {
    //return view('landlord.verify-email');
//})->name('landlord.verify.email');

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

Route::get('/landlord/applications/{rental}', [LandlordRentalController::class, 'applications'])
    ->name('landlord.applications.index');

Route::middleware(['landlord'])->group(function () {
    Route::get('/landlord/messages', fn () => view('landlord.messages'))->name('messages');
    Route::get('/landlord/support', fn () => view('landlord.support'))->name('landlord.support');
});

Route::get('/landlord/rentals/{rental}/applications', [LandlordRentalController::class, 'applications'])
    ->name('landlord.applications.index');

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

// MESSAGES LANDLORD

Route::get('/landlord/messages/{application}', [LandlordMessageController::class, 'show'])->name('landlord.messages.show');
Route::post('/landlord/messages/{application}', [LandlordMessageController::class, 'store'])->name('landlord.messages.store');
Route::get('/landlord/messages', [LandlordMessageController::class, 'index'])->name('landlord.messages');
    //service provider for landlord
Route::get('/landlord/service-provider-messages/{providerRequest}', [LandlordMessageController::class, 'showServiceProvider'])
    ->name('landlord.service-provider.messages.show');

Route::post('/landlord/service-provider-messages/{providerRequest}', [LandlordMessageController::class, 'storeServiceProvider'])
    ->name('landlord.service-provider.messages.store');

Route::post('/landlord/service-provider-messages/{providerRequest}/accept', [LandlordMessageController::class, 'acceptServiceProvider'])
    ->name('landlord.service-provider.messages.accept');

Route::post('/landlord/service-provider-messages/{providerRequest}/decline', [LandlordMessageController::class, 'declineServiceProvider'])
    ->name('landlord.service-provider.messages.decline');

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


//student messaging
Route::get('/student/messages', [StudentMessageController::class, 'index'])->name('student.messages');
Route::get('/student/messages/{application}', [StudentMessageController::class, 'show'])->name('student.messages.show');
Route::post('/student/messages/{application}', [StudentMessageController::class, 'store'])->name('student.messages.store');

    //student maintenance log 
Route::get('/student/maintenance/{application}', [StudentMaintenanceController::class, 'page'])->name('student.maintenance.log');
Route::get('/student/maintenance/{application}', [StudentMaintenanceController::class, 'page'])->name('student.maintenance-log');

Route::post('/student/maintenance/{application}', [StudentMaintenanceController::class, 'store'])->name('student.maintenance-log.store');

// Landlord maintenance log
Route::get('/landlord/maintenance/{application}', [LandlordMaintenanceController::class, 'page'])->name('landlord.maintenance-log');
Route::post('/landlord/maintenance/{application}/{log}', [LandlordMaintenanceController::class, 'update'])->name('landlord.maintenance-log.update');
// ===============================
// RENT TRACKER ROUTES (SESSION-BASED)
// ===============================

use App\Http\Controllers\RentTrackerController;

// Student (session) rent-tracker API
Route::get('/student/rent-tracker/balance', [RentTrackerController::class, 'getBalance']);
Route::get('/student/rent-tracker/history', [RentTrackerController::class, 'getHistory']);
Route::post('/student/rent-tracker/payment-intent', [RentTrackerController::class, 'createPaymentIntent']);
Route::post('/student/rent-tracker/confirm-payment', [RentTrackerController::class, 'confirmPayment']);
Route::get('/student/rent-tracker/{application}', [RentTrackerController::class, 'page'])
    ->name('student.rent.page');

// Landlord rent tracker (read-only)
use App\Http\Controllers\Landlord\LandlordRentTrackerController;
Route::get('/landlord/rent-tracker/balance', [LandlordRentTrackerController::class, 'getBalance']);
Route::get('/landlord/rent-tracker/history', [LandlordRentTrackerController::class, 'getHistory']);
Route::get('/landlord/rent-tracker/{application}', [LandlordRentTrackerController::class, 'page'])
    ->name('landlord.rent.page');

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

    // Students (ACTIVE only)
    Route::get('/students', function () {
        $students = \App\Models\Student::where('status', 'active')->get();
        return view('admin.student-accounts', compact('students'));
    })->name('admin.accounts.students');

    // Landlords (ACTIVE only)
    Route::get('/landlords', function () {
        $landlords = \App\Models\Landlord::where('status', 'active')->get();
        return view('admin.landlord-accounts', compact('landlords'));
    })->name('admin.accounts.landlords');

    // Service Providers (ACTIVE only)
    Route::get('/service-providers', function () {
        $providers = \App\Models\ServiceProviderPartnership::where('status', 'active')->get();
        return view('admin.serviceprovider-accounts', compact('providers'));
    })->name('admin.accounts.serviceproviders');

    Route::get('/group-applications', function (\Illuminate\Http\Request $req) {
    $term = trim($req->query('q', ''));

    $results = \App\Models\Application::with(['group.members', 'rental'])
        ->where('applicationtype', 'group')
        ->when($term !== '', function ($q) use ($term) {

            // Search by student ID → return all group apps they belong to
            if (ctype_digit($term)) {
                $q->whereIn('group_id', function ($sq) use ($term) {
                    $sq->select('group_id')
                       ->from('student_groups')
                       ->where('student_id', intval($term));
                });

            } else {
                // Search by listing address
                
            
                $like = '%' . $term . '%';

                $q->whereHas('rental', function ($r) use ($like) {
                    $r->where('street', 'like', $like)
                    ->orWhere('county', 'like', $like)
                    ->orWhere('postcode', 'like', $like)
                    ->orWhere('housenumber', 'like', $like)

                    // match "5 Western Road"
                    ->orWhereRaw("CONCAT(housenumber, ' ', street) LIKE ?", [$like])

                    // match "Western Road 5"
                    ->orWhereRaw("CONCAT(street, ' ', housenumber) LIKE ?", [$like])

                    // match "5 Western Road, Cork"
                    ->orWhereRaw("CONCAT(
                                        COALESCE(housenumber,''), ' ',
                                        COALESCE(street,''), ', ',
                                        COALESCE(county,'')
                                    ) LIKE ?", [$like]);


            });

            }
        })
        ->orderByDesc('dateapplied')
        ->paginate(20);

    return view('admin.group-applications', compact('results', 'term'));
    })->name('admin.accounts.groupapplications');

    
   // VIEW PAGE (single group application)
    Route::get('/group-applications/{id}', function ($id) {
        $app = \App\Models\Application::with(['group.members', 'rental'])
            ->findOrFail($id);

        return view('admin.view-group-applicationS', compact('app'));
    })->name('admin.accounts.groupapplications.view');


    // Suspended Accounts (ALL types shown here)
    Route::get('/suspended', function () {
        $students  = \App\Models\Student::where('status', 'suspended')->get();
        $landlords = \App\Models\Landlord::where('status', 'suspended')->get();
        $providers = \App\Models\ServiceProviderPartnership::where('status', 'suspended')->get();
        return view('admin.suspended-accounts', compact('students','landlords','providers'));
    })->name('admin.accounts.suspended');

    // ===========
    // VIEW PAGES
    // ===========
    Route::get('/students/{id}', function ($id) {
        $student = \App\Models\Student::findOrFail($id);
        return view('admin.view-student', compact('student'));
    })->name('admin.accounts.student.view');

    Route::get('/landlords/{id}', function ($id) {
        $landlord = \App\Models\Landlord::findOrFail($id);
        // Show their current listings (admin still sees even if suspended)
        $currentListings = \App\Models\LandlordRental::where('landlordid', $id)->get();
        return view('admin.view-landlord', compact('landlord','currentListings'));
    })->name('admin.accounts.landlord.view');

    Route::get('/service-providers/{id}', function ($id) {
        $provider = \App\Models\ServiceProviderPartnership::findOrFail($id);
        $admin = \App\Models\Staff::find($provider->administratorid);
        return view('admin.view-serviceprovider', compact('provider','admin'));
    })->name('admin.accounts.serviceprovider.view');

    // Listing detail page (admin)
    Route::get('/listing/{id}', function ($id) {
        $rental    = \App\Models\LandlordRental::findOrFail($id);
        $landlord  = \App\Models\Landlord::find($rental->landlordid);
        return view('admin.view-listing', compact('rental','landlord'));
    })->name('admin.listing.view');

    // ==========================
    // SUSPEND / REACTIVATE (RAW SQL)
    // ==========================
    Route::post('/suspend/{type}/{id}', function ($type, $id) {
        if ($type === 'student') {
            DB::update("UPDATE `student` SET `status` = 'suspended' WHERE `id` = ?", [$id]);
            return back();
        }
        if ($type === 'landlord') {
            DB::update("UPDATE `landlord` SET `status` = 'suspended' WHERE `id` = ?", [$id]);
            return back();
        }
        if ($type === 'serviceprovider') {
            DB::update("UPDATE `serviceproviderpartnership` SET `status` = 'suspended' WHERE `id` = ?", [$id]);
            return back();
        }
        abort(404);
    })->name('admin.accounts.suspend');

    Route::post('/reactivate/{type}/{id}', function ($type, $id) {
        if ($type === 'student') {
            DB::update("UPDATE `student` SET `status` = 'active' WHERE `id` = ?", [$id]);
            return back();
        }
        if ($type === 'landlord') {
            DB::update("UPDATE `landlord` SET `status` = 'active' WHERE `id` = ?", [$id]);
            return back();
        }
        if ($type === 'serviceprovider') {
            DB::update("UPDATE `serviceproviderpartnership` SET `status` = 'active' WHERE `id` = ?", [$id]);
            return back();
        }
        abort(404);
    })->name('admin.accounts.reactivate');

});


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






//Route::get('/student/messages', function () {
    //if (!session('student_id')) return redirect('/student/login');
    //return view('student.messages');
//})->name('student.messages');

Route::get('/student/support', function () {
    if (!session('student_id')) return redirect('/student/login');
    
   return view('student.support');
})->name('student.support');

// ===============================
// STUDENT: VIEW A SINGLE LISTING
// ===============================
Route::get('/listing/{id}', [App\Http\Controllers\StudentRegisterController::class, 'showListing'])
    ->name('listing.show');

// ===============================
// APPLICATION ROUTES (SINGLE/GROUP)
// ===============================
Route::get('/applications/start/{listing}/{type}', 
    [App\Http\Controllers\ApplicationController::class, 'start'])
    ->name('applications.start');

Route::post('/applications/submit/single/{listing}', 
    [App\Http\Controllers\ApplicationController::class, 'submitSingle'])
    ->name('applications.submit.single');

Route::post('/applications/submit/group/{listing}',
    [App\Http\Controllers\ApplicationController::class, 'submitGroup'])
    ->name('applications.submit.group');


Route::get('/landlord/listing/{id}/applications',
    [\App\Http\Controllers\LandlordController::class, 'viewApplications'])
    ->name('landlord.listing.applications');


Route::get('/landlord/rentals/{rental}/applications',
    [\App\Http\Controllers\Landlord\LandlordRentalController::class, 'applications'])
    ->name('landlord.applications.index');


Route::get('/landlord/rentals/{rental}/applications', [LandlordRentalController::class, 'applications'])
    ->name('landlord.applications.index');

Route::post('/landlord/applications/{application}/accept', [LandlordRentalController::class, 'acceptApplication'])
    ->name('landlord.applications.accept');

Route::post('/landlord/applications/{application}/reject', [LandlordRentalController::class, 'rejectApplication'])
    ->name('landlord.applications.reject');


Route::delete('/applications/{id}/withdraw', [\App\Http\Controllers\ApplicationController::class, 'withdraw'])
    ->name('applications.withdraw');
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
    /* 



/* ===========================
   SERVICE PROVIDER ROUTES
   =========================== */

Route::get('/serviceprovider/dashboard', function () {
    if (!session('serviceprovider_id')) return redirect('/login');
    return redirect()->route('serviceprovider.upcoming');
})->name('serviceprovider.dashboard');

Route::get('/serviceprovider/upcoming', [ServiceProviderUpcomingJobsController::class, 'index'])
    ->name('serviceprovider.upcoming');

Route::get('/serviceprovider/completed', function () {
    if (!session('serviceprovider_id')) return redirect('/login');
    return view('serviceprovider.completed');
})->name('serviceprovider.completed');

Route::get('/serviceprovider/requested', [ServiceProviderRequestedJobsController::class, 'index'])
    ->name('serviceprovider.requested');

Route::get('/serviceprovider/messages', [ServiceProviderMessageController::class, 'index'])
    ->name('serviceprovider.messages');

Route::get('/serviceprovider/messages/{id}', [ServiceProviderMessageController::class, 'show'])
    ->name('serviceprovider.messages.show');

Route::post('/serviceprovider/messages/{id}', [ServiceProviderMessageController::class, 'store'])
    ->name('serviceprovider.messages.store');

Route::get('/serviceprovider/profile', function () {
    if (!session('serviceprovider_id')) return redirect('/login');
    return view('serviceprovider.profile');
})->name('serviceprovider.profile');