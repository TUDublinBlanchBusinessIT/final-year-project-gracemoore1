<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = \DB::table('administrator')
            ->join('staff', 'administrator.id', '=', 'staff.id')
            ->where('staff.email', $request->email)
            ->select(
                'administrator.id as admin_id',
                'staff.firstname',
                'staff.password as staff_password'
            )
            ->first();

        if ($admin && Hash::check($request->password, $admin->staff_password)) {

            session([
                'admin_id'        => $admin->admin_id,
                'role'            => 'admin',
                'admin_firstname' => $admin->firstname
            ]);

            return redirect()->route('admin.dashboard');
        }



    // hardcode for admins here
    
        //$admins = [
            //[
                //'email' => 'B00153832@mytudublin.ie',
                //'password' => '$2y$12$7sVW45vjjvXNnQQnNPYHWubMt59UcNMiTljQrTugiolNVzLWugK9C',  // MoyaGrace123
                //'id' => 5,
                //'firstname' => 'Moya'
            //],
            //[
                //'email' => 'gmoore0001@icloud.com',
                //'password' => '$2y$12$7sVW45vjjvXNnQQnNPYHWubMt59UcNMiTljQrTugiolNVzLWugK9C',  // MoyaGrace123
                //'id' => 6,
                //'firstname' => 'Grace'
            //]
        //];
        
        //foreach ($admins as $admin) {
            //if ($admin['email'] === $request->email) {
        // Debug: Check if the password matches the hash
                //$result = Hash::check($request->password, $admin['password']);
                //if ($result) {
            // Success: log in admin
                    //session(['admin_id' => $admin['id']]);
                    //session(['role' => 'admin']);
                    //session(['admin_firstname' => $admin['firstname']]);
                    //return redirect()->route('admin.dashboard');
            //}
        //}


    // Check Student
        $student = \App\Models\Student::where('email', $request->email)->first();
        if ($student && \Illuminate\Support\Facades\Hash::check($request->password, $student->password)) {
            // Optionally check for email/ID verification if you want
            if (!$student->email_verified) {
                return back()->withErrors(['email' => 'Please verify your email before logging in.']);
            }
            if (!$student->id_verified) {
                return back()->withErrors(['email' => 'Your identity has not been verified yet.']);
            }
            $request->session()->put('student_id', $student->id);
            $request->session()->forget('landlord_id');
            return redirect()->route('student.dashboard');
        }

        // Check Landlord
        $landlord = \App\Models\Landlord::where('email', $request->email)->first();
        if ($landlord && \Illuminate\Support\Facades\Hash::check($request->password, $landlord->password)) {
            // If you have similar verification for landlords, add here
            $request->session()->put('landlord_id', $landlord->id);
            $request->session()->forget('student_id');
            return redirect()->route('landlord.dashboard');
        }

        // Not found or wrong password
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
