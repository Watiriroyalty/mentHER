<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $skills = Skill::all();
        return view('skills.index', compact('skills'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('skills.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validation logic
        $request->validate([
            'name' => 'required|string|unique:skills',
        ]);

        // Create a new Skill instance and save it
        Skill::create($request->all());

        return redirect()->route('skills.index')->with('success', 'Skill created successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $skill = Skill::findOrFail($id);
        return view('skills.show', compact('skill'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        return view('skills.edit', compact('skill'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Validation logic
        $request->validate([
            'name' => 'required|string|unique:skills,name,' . $id,
        ]);

        // Find the Skill and update its attributes
        $skill = Skill::findOrFail($id);
        $skill->update($request->all());

        return redirect()->route('skills.index')->with('success', 'Skill updated successfully.');
    }

    public function editProfile()
{
    $user = auth()->user(); // Get the authenticated user

    // Retrieve all skills
    $skills = Skill::all();

    // Get the IDs of the user's skills
    $userSkills = $user->skills->pluck('id')->toArray();

    return view('profile.edit', compact('user', 'skills', 'userSkills'));
}

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Find the Skill and delete it
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully.');
    }
}


