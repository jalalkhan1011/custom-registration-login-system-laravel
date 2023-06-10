<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function customLogin()
    {
        return view('auth.login');
    }

    public function customRegistration()
    {
        return view('auth.register');
    }

    public function registrationSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($data) {
            return back()->with('success', 'You are register user');
        } else {
            return back()->with('fail', 'Something want wrong please try angain!');
        }
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);



        $user = Customer::where('email', $request->email)->first();
        $admin = Admin::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginId', $user->id);
                return redirect(route('customDashboard'));
            } else {
                return back()->with('fail', 'Password Not Match');
            }
        } elseif ($admin) {
            if (Hash::check($request->password, $admin->password)) {
                $request->session()->put('loginId', $admin->id);
                return redirect(route('adminDashboard'));
            } else {
                return back()->with('fail', 'Password Not Match');
            }
        } else {
            return back()->with('fail', 'This email not registered');
        }
    }

    public function dashboard()
    {
        $user = [];
        if (Session::has('loginId')) {
            $user = Customer::where('id', Session::has('loginId'))->first();
        }
        return view('dashboard', compact('user'));
    }

    public function adminDashboard()
    {
        $user = [];
        if (Session::has('loginId')) {
            $user = Admin::where('id', Session::has('loginId'))->first();
        }
        return view('adminDashbord', compact('user'));
    }

    public function customLogout()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');

            return redirect(route('customLogin'));
        }
    }
}
