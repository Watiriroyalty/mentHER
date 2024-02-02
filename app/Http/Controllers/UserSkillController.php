<?php

namespace App\Http\Controllers;

use App\Models\UserSkill;
use Illuminate\Http\Request;

class UserSkillController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $userSkills = UserSkill::all();
        return view('user_skills.index', compact('userSkills'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // You can fetch users and skills from the database and pass them to the view
        $users = \App\Models\User::all();
        $skills = \App\Models\Skill::all();

        return view('user_skills.create', compact('users', 'skills'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validation logic
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'skill_id' => 'required|exists:skills,id',
        ]);

        // Create a new UserSkill instance and save it
        UserSkill::create($request->all());

        return redirect()->route('user_skills.index')->with('success', 'UserSkill created successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $userSkill = UserSkill::findOrFail($id);
        return view('user_skills.show', compact('userSkill'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $userSkill = UserSkill::findOrFail($id);
        $users = \App\Models\User::all();
        $skills = \App\Models\Skill::all();

        return view('user_skills.edit', compact('userSkill', 'users', 'skills'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Validation logic
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'skill_id' => 'required|exists:skills,id',
        ]);

        // Find the UserSkill and update its attributes
        $userSkill = UserSkill::findOrFail($id);
        $userSkill->update($request->all());

        return redirect()->route('user_skills.index')->with('success', 'UserSkill updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Find the UserSkill and delete it
        $userSkill = UserSkill::findOrFail($id);
        $userSkill->delete();

        return redirect()->route('user_skills.index')->with('success', 'UserSkill deleted successfully.');
    }
}

