<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            // បានកែពី 'max::255' ទៅជា 'max:255'
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // មិនឱ្យលើស 2MB
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;

        // ពិនិត្យមើលថាតើមាន Upload រូបភាពថ្មីដែរឬទេ
        if ($request->hasFile('profile_image')) {
            // លុបរូបភាពចាស់ចោលបើមាន
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // ផ្ទុកទិន្នន័យរូបភាពថ្មីចូលទៅកាន់ folder "profile_images" ក្នុង public storage
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete profile
     */
    public function destroy()
    {
        return back()->with('success', 'Profile deleted successfully');
    }
}
