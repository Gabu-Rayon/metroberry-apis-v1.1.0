<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }


    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // public function update(Request $request)
    // {
    //     $user = Auth::user();

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => [
    //             'required',
    //             'email',
    //             'max:255',
    //             Rule::unique('users')->ignore($user->id),
    //         ],
    //         'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'address' => 'nullable|string|max:255',
    //         'phone' => 'nullable|string|max:15',
    //     ]);

    //     $user->name = $request->input('name');
    //     $user->email = $request->input('email');
    //     $user->address = $request->input('address');
    //     $user->phone = $request->input('phone');

    //     // Check if the user has uploaded a new avatar
    //     if ($request->hasFile('avatar')) {
    //         // If the user already has an avatar, delete the old one
    //         if ($user->avatar) {
    //             $oldAvatarPath = public_path($user->avatar);
    //             if (file_exists($oldAvatarPath)) {
    //                 unlink($oldAvatarPath); // Delete the old avatar file
    //             }
    //         }

    //         // Define the path where the avatar will be saved
    //         $avatarDirectory = public_path('avatars');
    //         // Create the directory if it doesn't exist
    //         if (!file_exists($avatarDirectory)) {
    //             mkdir($avatarDirectory, 0755, true); // Create the directory if it doesn't exist
    //         }

    //         // Store the new avatar in the public directory
    //         $file = $request->file('avatar');
    //         $fileName = time() . '_' . $file->getClientOriginalName(); // Create a unique file name
    //         $file->move($avatarDirectory, $fileName); // Move the file to the avatars directory

    //         $user->avatar = 'avatars/' . $fileName; // Update the avatar path in the user model
    //     }

    //     $user->save();

    //     return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    // }


    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');

        // Check if the user has uploaded a new avatar
        if ($request->hasFile('avatar')) {
            // If the user already has an avatar, delete the old one
            if ($user->avatar) {
                $oldAvatarPath = public_path($user->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath); // Delete the old avatar file
                }
            }

            // Define the path to the portal_public_html directory
            $avatarDirectory = '/home/kknuicdz/portal_public_html/avatars'; // Adjust the path as necessary

            // Create the directory if it doesn't exist
            if (!file_exists($avatarDirectory)) {
                mkdir($avatarDirectory, 0755, true); // Create the directory if it doesn't exist
            }

            // Store the new avatar in the public directory
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Create a unique file name
            $file->move($avatarDirectory, $fileName); // Move the file to the avatars directory

            $user->avatar = 'avatars/' . $fileName; // Update the avatar path in the user model
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate the current password
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Log out the user
        Auth::logout();

        // Delete the user's avatar file if it exists
        if ($user->avatar) {
            $oldAvatarPath = public_path($user->avatar);
            if (file_exists($oldAvatarPath)) {
                unlink($oldAvatarPath); // Delete the old avatar file
            }
        }

        // Delete the user
        $user->delete();

        // Invalidate the session and regenerate the token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Account deleted successfully.');
    }

}