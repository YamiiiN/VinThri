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
        // Validate user registration data
        $userData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'type' => "0", // Assuming type 0 represents a regular user
        ]);

         // Validate customer data including images
        $customerData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'address' => 'required|string',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Update to 'image.*' for multiple images
        ]);
        

        // Create a new customer associated with the user
        $customer = $user->customer()->create([
            'first_name' => $customerData['first_name'],
            'last_name' => $customerData['last_name'],
            'email' => $customerData['email'],
            'password' => Hash::make($customerData['password']),
            'type' => "0", // Assuming type 0 represents a regular customer
            'address' => $customerData['address'],
            'image' => '', // Initialize the image field with an empty string
        ]);

        // Upload and save the images if they exist
        if ($request->hasFile('image')) {
            $imagePaths = [];
            foreach ($request->file('image') as $image) {
                $imagePath = $image->store('productImages');
                $imagePaths[] = $imagePath;
            }
            $customer->image = implode(',', $imagePaths); // Concatenate image paths into a comma-separated string
            $customer->save();
        }

         // Send email verification notification
         $user->sendEmailVerificationNotification();

         return view('verification.notice');
    }
    // public function registerSave(Request $request)
    // {
    //     // Validate user registration data
    //     $userData = $request->validate([
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|confirmed',
    //     ]);

    //     // Create a new user
    //     $user = User::create([
    //         'first_name' => $userData['first_name'],
    //         'last_name' => $userData['last_name'],
    //         'email' => $userData['email'],
    //         'password' => Hash::make($userData['password']),
    //         'type' => "0", // Assuming type 0 represents a regular user
    //     ]);

    //     // Validate customer data including images
    //     $customerData = $request->validate([
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|confirmed',
    //         'address' => 'required|string',
    //         'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Update to 'image.*' for multiple images
    //     ]);
        

    //     // Create a new customer associated with the user
    //     $customer = $user->customer()->create([
    //         'first_name' => $customerData['first_name'],
    //         'last_name' => $customerData['last_name'],
    //         'email' => $customerData['email'],
    //         'password' => Hash::make($customerData['password']),
    //         'type' => "0", // Assuming type 0 represents a regular customer
    //         'address' => $customerData['address'],
    //         'image' => '', // Initialize the image field with an empty string
    //     ]);

    //     // Upload and save the images if they exist
    //     if ($request->hasFile('image')) {
    //         $imagePaths = [];
    //         foreach ($request->file('image') as $image) {
    //             $imagePath = $image->store('productImages');
    //             $imagePaths[] = $imagePath;
    //         }
    //         $customer->image = implode(',', $imagePaths); // Concatenate image paths into a comma-separated string
    //         $customer->save();
    //     }

    //     $user->sendEmailVerificationNotification();

    //     return redirect()->route('verification.notice');
        
    // }

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