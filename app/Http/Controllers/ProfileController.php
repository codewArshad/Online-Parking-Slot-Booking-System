<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the logged-in user's profile.
     */
    public function show()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    /**
     * Update the logged-in user's name and phone only.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        Auth::user()->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
