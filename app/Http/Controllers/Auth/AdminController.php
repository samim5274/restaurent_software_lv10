<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Session;

use App\Models\Admin;
use App\Models\Company;

class AdminController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function userLogin(Request $request){
        $request->validate([
            'txtEmail' => 'required|email',
            'txtPassword' => 'required',
        ]);

        $credentials = [
            'email' => $request->txtEmail,
            'password' => $request->txtPassword,
            'status' => 1, // only active admins
        ];

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect('/');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password. Please try again!');
        }
    }

    public function createUser(Request $request) {
        
        $request->validate([
            'txtName'     => 'required|string|max:255',
            'txtEmail'    => 'required|email|unique:admins,email',
            'dtpDob'      => 'nullable|date',
            'txtPassword' => 'required|min:6',
            'txtPhone'    => 'nullable|string|max:20',
            'txtAddress'  => 'nullable|string|max:255',
            'cbxRole'     => 'nullable|integer',
        ]);

        $user = new Admin();
        $user->name     = $request->txtName;
        $user->email    = $request->txtEmail;
        $user->dob      = $request->dtpDob;
        $user->password = Hash::make($request->txtPassword);
        $user->phone    = $request->txtPhone;
        $user->address  = $request->txtAddress;
        $user->role     = $request->cbxRole ?? 0; // default role 0
        $user->status   = 0; // default inactive
        $user->save();
        return redirect()->back()->with('success', 'New user created successfully!');
    }

    public function users(){
        $company = Company::first();
        $users = Admin::all();
        return view('auth.user-details', compact('company', 'users'));
    }
}
