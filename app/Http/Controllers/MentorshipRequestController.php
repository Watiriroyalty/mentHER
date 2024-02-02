<?php

namespace App\Http\Controllers;

use App\Models\MentorshipRequest;
use Illuminate\Http\Request;

class MentorshipRequestController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
    $user = auth()->user();
    $receivedRequests = MentorshipRequest::where('mentor_id', $user->id)->get();
    $sentRequests = MentorshipRequest::where('mentee_id', $user->id)->get();

    return view('mentorship_requests.index', compact('receivedRequests', 'sentRequests'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // You can fetch mentees and mentors from the database and pass them to the view
        $mentees = \App\Models\User::where('role', 'mentee')->get();
        $mentors = \App\Models\User::where('role', 'mentor')->get();

        return view('mentorship_requests.create', compact('mentees', 'mentors'));
    }

    public function updateStatus($id)
    {
    // Validate the request
    request()->validate([
        'status' => 'required|in:accepted,declined',
    ]);

    // Find the mentorship request by ID
    $request = MentorshipRequest::findOrFail($id);

    // Update the status
    $request->update(['status' => request('status')]);

    return response()->json(['message' => 'Request status updated successfully']);
    }   
    
    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validation logic
        $request->validate([
            'mentee_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'status' => 'in:pending,accepted,declined',
        ]);
    
        // Check if a pending request already exists for the same mentor and mentee
        $existingRequest = MentorshipRequest::where('mentee_id', $request->mentee_id)
            ->where('mentor_id', $request->mentor_id)
            ->where('status', 'pending')
            ->first();
    
        if ($existingRequest) {
            return redirect()->route('mentorship_request.index')->with('error', 'A pending request already exists for this mentor.');
        }
    
        // Create a new MentorshipRequest instance and save it
        MentorshipRequest::create($request->all());
    
        return redirect()->route('mentorship_request.index')->with('success', 'Mentorship Request created successfully.');
    }
    

    // Display the specified resource.
    public function show($id)
    {
        $mentorshipRequest = MentorshipRequest::findOrFail($id);
        return view('mentorship_requests.show', compact('mentorshipRequest'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $mentorshipRequest = MentorshipRequest::findOrFail($id);
        $mentees = \App\Models\User::where('role', 'mentee')->get();
        $mentors = \App\Models\User::where('role', 'mentor')->get();

        return view('mentorship_requests.edit', compact('mentorshipRequest', 'mentees', 'mentors'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Validation logic
        $request->validate([
            'mentee_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'status' => 'in:pending,accepted,declined',
        ]);

        // Find the MentorshipRequest and update its attributes
        $mentorshipRequest = MentorshipRequest::findOrFail($id);
        $mentorshipRequest->update($request->all());

        return redirect()->route('mentorship_requests.index')->with('success', 'Mentorship Request updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Find the MentorshipRequest and delete it
        $mentorshipRequest = MentorshipRequest::findOrFail($id);
        $mentorshipRequest->delete();

        return redirect()->route('mentorship_requests.index')->with('success', 'Mentorship Request deleted successfully.');
    }
}
