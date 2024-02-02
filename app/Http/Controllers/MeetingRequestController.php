<?php

namespace App\Http\Controllers;

use App\Models\MeetingRequest;
use Illuminate\Http\Request;

class MeetingRequestController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $meetingRequests = MeetingRequest::all();
        return view('meeting_requests.index', compact('meetingRequests'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // You can fetch requesters and recipients from the database and pass them to the view
        $requesters = \App\Models\User::all();
        $recipients = \App\Models\User::all();

        return view('meeting_requests.create', compact('requesters', 'recipients'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validation logic
        $request->validate([
            'requester_id' => 'required|exists:users,id',
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'status' => 'in:pending,accepted,declined',
            'proposed_datetime' => 'required|date',
        ]);

        // Create a new MeetingRequest instance and save it
        MeetingRequest::create($request->all());

        return redirect()->route('meeting_requests.index')->with('success', 'Meeting Request created successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $meetingRequest = MeetingRequest::findOrFail($id);
        return view('meeting_requests.show', compact('meetingRequest'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $meetingRequest = MeetingRequest::findOrFail($id);
        $requesters = \App\Models\User::all();
        $recipients = \App\Models\User::all();

        return view('meeting_requests.edit', compact('meetingRequest', 'requesters', 'recipients'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Validation logic
        $request->validate([
            'requester_id' => 'required|exists:users,id',
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'status' => 'in:pending,accepted,declined',
            'proposed_datetime' => 'required|date',
        ]);

        // Find the MeetingRequest and update its attributes
        $meetingRequest = MeetingRequest::findOrFail($id);
        $meetingRequest->update($request->all());

        return redirect()->route('meeting_requests.index')->with('success', 'Meeting Request updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Find the MeetingRequest and delete it
        $meetingRequest = MeetingRequest::findOrFail($id);
        $meetingRequest->delete();

        return redirect()->route('meeting_requests.index')->with('success', 'Meeting Request deleted successfully.');
    }
}
