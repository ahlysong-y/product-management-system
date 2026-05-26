<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display profile page
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        return back()->with('success', 'Profile updated successfully');
    }

    /**
     * Delete profile
     */
    public function destroy()
    {
        return back()->with('success', 'Profile deleted successfully');
    }
}