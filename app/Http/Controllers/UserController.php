<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    
    public function dashboard()
    {
        // Assuming you want to retrieve all users for the dashboard
        $users = User::all();
    
        return view('dashboard', ['users' => $users]);
    }
    
    // Show the form for creating a new resource.
    public function create()
    {
        return view('users.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validation logic
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/',
            ],
            'role' => ['required', Rule::in($request->input('gender') === 'female' ? ['mentor', 'mentee'] : ['mentor'])],            'gender' => 'nullable|in:male,female',
            'experience' => ['required', 'in:0-2,2-5,5-10,more-than-10'],
            // Add other fields as needed
        ]);
    
        // Create a new User instance and save it
        User::create($request->all());
    
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Validation logic
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/',
            ],
            'gender' => ['required', 'in:male,female'],
            'role' => ['required_if:gender,female', Rule::in(['mentor', 'mentee'])],
            'experience' => ['required', 'in:0-2,2-5,5-10,more-than-10'],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Add other fields as needed
        ]);
    
        // Find the User and update its attributes
        $user = User::findOrFail($id);
        $user->update($request->except('profile_picture'));
    
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $uploadedFile = $request->file('profile_picture');
            $path = $uploadedFile->storeAs('profile_pictures', 'user_' . $user->id . '.' . $uploadedFile->getClientOriginalExtension(), 'public');
    
            // Update the user's profile picture URL
            $user->update([
                'profile_picture_url' => Storage::url($path),
            ]);
        }
    
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Find the User and delete it
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
