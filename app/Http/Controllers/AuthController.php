<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Verified;

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
        $userData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'type' => "0", 
        ]);

        $customerData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'address' => 'required|string',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        $customer = $user->customer()->create([
            'first_name' => $customerData['first_name'],
            'last_name' => $customerData['last_name'],
            'email' => $customerData['email'],
            'password' => Hash::make($customerData['password']),
            'type' => "0", 
            'address' => $customerData['address'],
            'image' => '', 
        ]);

        if ($request->hasFile('image')) {
            $imagePaths = [];
            foreach ($request->file('image') as $image) {
                $imagePath = $image->store('productImages');
                $imagePaths[] = $imagePath;
            }
            $customer->image = implode(',', $imagePaths);
            $customer->save();
        }

        $user->sendEmailVerificationNotification();

        return view('auth/login');
    }

    public function verifyEmail(Request $request)
    {
        if ($request->route('id') == $request->user()->getKey() &&
            URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $request->user()->getKey(), 'hash' => sha1($request->user()->getEmailForVerification())]
            ) === $request->url()) {
            $request->user()->markEmailAsVerified();

            event(new Verified($request->user()));
        }

        return redirect('/home');
    }

    public function sendEmailVerificationNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }


    public function login(Request $request)
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

        $loggedInUser = auth()->user();

        if (!$loggedInUser->hasVerifiedEmail()) {
            return view('verification.notice');
        }

        $request->session()->regenerate();

        if ($loggedInUser->type == 'admin') {
            
            $existingAdmin = Admin::where('email', $loggedInUser->email)->first();

            if (!$existingAdmin) {
                Admin::create([
                    'first_name' => $loggedInUser->first_name,
                    'last_name' => $loggedInUser->last_name,
                    'image' => null,
                    'address' => null,
                    'email' => $loggedInUser->email,
                    'password' => $loggedInUser->password,
                    'user_id' => $loggedInUser->user_id,
                ]);
            }

            return redirect()->route('admin.home');
        } else {
            return redirect()->route('home');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
}