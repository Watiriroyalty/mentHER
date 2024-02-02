<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Notifications\NewReplyNotification;

class MessageController extends Controller
{
    // Display a listing of the resource.
    public function index(): View
    {
        $user = Auth::user();

        // Load all messages for the authenticated user
        $messages = Message::where('receiver_id', $user->id)->get();

        // Mark messages as read
        $user->unreadNotifications->markAsRead();

        return view('messages.index', compact('messages'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // You can fetch users from the database and pass them to the view
        $users = \App\Models\User::all();

        return view('messages.create', compact('users'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validation logic
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        // Create a new Message instance and save it
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->input('receiver_id'),
            'message' => $request->input('message'),
        ]);

        // Notify the receiver about the new message
        $receiver = \App\Models\User::findOrFail($request->input('receiver_id'));
        //Notification::send($receiver, new NewMessageNotification($message));

        return redirect()->route('messages.index')->with('success', 'Message sent successfully.');
    }

    public function reply(Request $request, Message $message)
    {
        // Validation logic for the reply
        $request->validate([
            'reply' => 'required|string',
        ]);

        // Assuming you have a relationship set up between Message and User models
        $sender = $message->sender;

        // Create a new Message instance for the reply
        $replyMessage = new Message([
            'sender_id' => auth()->id(),
            'receiver_id' => $sender->id,
            'message' => $request->input('reply'),
        ]);

        // Save the reply message
        $replyMessage->save();

        // Notify the sender about the reply
        $sender->notify(new NewReplyNotification($replyMessage));

        return redirect()->route('messages.index')->with('success', 'Reply sent successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $message = Message::findOrFail($id);
        return view('messages.show', compact('message'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $message = Message::findOrFail($id);
        $users = \App\Models\User::all();

        return view('messages.edit', compact('message', 'users'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Validation logic
        $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        // Find the Message and update its attributes
        $message = Message::findOrFail($id);
        $message->update($request->all());

        return redirect()->route('messages.index')->with('success', 'Message updated successfully.');
    }

   // Remove the specified resource from storage.
public function destroy($id)
{
    // Find the Message and delete it
    $message = Message::findOrFail($id);
    $message->delete();

    return redirect()->route('messages.index')->with('success', 'Message deleted successfully.');
}

// Delete a message and its replies
public function delete(Message $message)
{
    // Delete the message
    $message->delete();

    return redirect()->route('messages.index')->with('success', 'Message deleted successfully.');
}
}
