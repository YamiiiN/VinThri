<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Models\Admin;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();
 
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => "0",
        ]);
 
        return redirect()->route('login');
    }

    public function login()
    {
        return view('auth/login');
    }


    public function loginAction(Request $request)
{
    Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ])->validate();

    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        throw ValidationException::withMessages([
            'email' => trans('auth.failed')
        ]);
    }

    $request->session()->regenerate();

    $loggedInUser = auth()->user();

    if ($loggedInUser->type == 'admin') {
        // Check if the admin record already exists based on the email
        $existingAdmin = Admin::where('email', $loggedInUser->email)->first();

        if (!$existingAdmin) {
            // Create admin record if it doesn't exist
            Admin::create([
                'first_name' => $loggedInUser->first_name,
                'last_name' => $loggedInUser->last_name,
                'image' => null,
                'address' => null,
                'email' => $loggedInUser->email,
                'password' => $loggedInUser->password,
                'user_id' => $loggedInUser->user_id,
                // Add any other fields you want to include in the admin record
            ]);
        }
    }

    // Redirect based on the user's type or other logic
    if ($loggedInUser->type == 'admin') {
        return redirect()->route('admin/home');
    } else {
        return redirect()->route('home');
    }
}
    // public function loginAction(Request $request)
    // {
    //     Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ])->validate();
 
    //     if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
    //         throw ValidationException::withMessages([
    //             'email' => trans('auth.failed')
    //         ]);
    //     }
 
    //     $request->session()->regenerate();
 
    //     if (auth()->user()->type == 'admin') {
    //         return redirect()->route('admin/home');
    //     } else {
    //         return redirect()->route('home');
    //     }
         
    //     // return redirect()->route('dashboard');
    // }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
 
        $request->session()->invalidate();
 
        return redirect('/login');
    }
}
