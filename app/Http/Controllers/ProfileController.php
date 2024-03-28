<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        // Fetch the currently authenticated user
        $user = auth()->user();

        // Pass the user data to the view
        return view('auth.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        $user = auth()->user();
        $userId = $user->user_id;

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId . ',user_id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update the user's profile with the validated data
        $user->update($validatedData);

        // Redirect the user back to the profile page or any other page
        return redirect()->route('home')->with('success', 'Profile updated successfully.');
    }


}
