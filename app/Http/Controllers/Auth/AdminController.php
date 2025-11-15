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

    public function SearchEmp(Request $request) {
        $output = '';
        $search = $request->input('search', '');

        $employees = Admin::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%')
            ->get();

        if ($employees->count() > 0) {
            foreach ($employees as $key => $val) {
                $imgpath = asset('img/employee/' . $val->photo);
                $link1 = url('/update-employee-status/' . $val->id);
                $statusBtn = $val->status == 1
                    ? '<button class="btn btn-success btn-sm" type="submit">Active</button>'
                    : '<button class="btn btn-danger btn-sm" type="submit">Deactive</button>';
                if($val->role == 1){
                    $roleName = "Admin";
                } elseif($val->role == 2) {
                    $roleName = "Manager";
                } elseif($val->role == 3) {
                    $roleName = "Waiter";
                } elseif($val->role == 4) {
                    $roleName = "Chef";
                } else {
                    $roleName = "Unknown";
                }

                $output .= '
                    <tr>
                        <td>' . ($key + 1) . '</td>
                        <td><img src="' . $imgpath . '" alt="Image not found" alt="Photo" width="50" height="50" class="rounded-circle"></td>
                        <td>' . $val->name . '</td>
                        <td>' . $val->email . '</td>
                        <td>' . $val->phone . '</td>
                        <td>' . $roleName . '</td>
                        <td>' . $val->dob . '</td>
                        <td>' . $val->address . '</td>
                        <td class="text-center">
                            <form action="' . $link1 . '" method="get">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                ' . $statusBtn . '
                            </form>
                        </td>
                    </tr>';
            }
        } else {
            $output = '<tr><td colspan="9" class="text-center text-danger">No employees found.</td></tr>';
        }

        return response($output);
    }

    public function updateStatus($id){
        $user = Admin::where('id', $id)->first();
        if(empty($user)){
            return redirect()->back()->with('warning', 'User not found. please try again. Thank You!');
        }
        $user->status = $user->status == 0 ? 1 : 0;
        $user->update();
        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function profile(){
        $user = Auth::guard('admin')->user();
        $company = Company::first();
        return view('auth.profile', compact('user', 'company'));
    }

    public function editProfile(Request $request, $id){
        $user = Admin::where('id', $id)->first();
        if(empty($user)){
            return redirect()->back()->with('error', 'User not found. please try again latter.');
        }

        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob');   

        if ($request->file('photo')) {

            if ($user->photo) {
                $path = public_path('img/employee/' . $user->photo);
                logger("Trying to delete: " . $path);
                if (file_exists($path)) {
                    unlink($path);
                } else {
                    logger("File not found: " . $path);
                }
            }

            $file = $request->file('photo');
            if ($file->isValid()) {
                $ext = $file->getClientOriginalExtension();
                $fileName = 'user-' . time() . '.' . $ext;

                $location = public_path('img/employee/');

                if (!file_exists($location)) {
                    mkdir($location, 0755, true);
                }

                $file->move($location, $fileName);
                $user->photo = $fileName;
            }
        }

        $user->update();
        return redirect()->back()->with('success', 'User information updated successfully.');
    }
}
