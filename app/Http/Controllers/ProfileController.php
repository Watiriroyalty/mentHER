<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Skill;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $skills = Skill::all(); // Retrieve all skills

        // Get the IDs of the user's skills
        $userSkills = $user->skills->pluck('id')->toArray();

        return view('profile.edit', compact('user', 'skills', 'userSkills'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $uploadedFile = $request->file('profile_picture');
            $path = $uploadedFile->storeAs('profile_pictures', 'user_' . $user->id . '.' . $uploadedFile->getClientOriginalExtension(), 'public');

            // Update the user's profile picture URL
            $user->update([
                'profile_picture_url' => asset('storage/' . $path),
            ]);
        }

        $user->save();

        // Sync user's skills
        $user->skills()->sync($request->input('skills', []));

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
