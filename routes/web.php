<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MentorshipRequestController;
use App\Http\Controllers\MatchController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\MeetingRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Group all routes that require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{message}', [MessageController::class, 'delete'])->name('messages.delete');

  
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mentorship_requests', [MentorshipRequestController::class, 'index'])->name('mentorship_request.index');
    Route::post('/mentorship_requests', [MentorshipRequestController::class, 'store'])->name('mentorship_requests.store');
    Route::post('/update-request-status/{id}', [MentorshipRequestController::class, 'updateStatus']);
   
    Route::patch('/mentorship-requests/{id}/update-status', [MentorshipRequestController::class, 'updateStatus'])
    ->name('mentorship_requests.updateStatus');
    Route::post('/mentorship_requests/updateStatus/{id}', [MentorshipRequestController::class, 'updateStatus']);

    Route::get('/potential-matches', [MatchController::class, 'showPotentialMatches'])
    ->name('potential-matches');

    Route::match(['get', 'post'], '/botman', 'BotManController@handle');

    // Meeting Request Routes
    Route::get('/meeting-requests', [MeetingRequestController::class, 'index'])->name('meeting_requests.index');
    Route::get('/meeting-requests/create', [MeetingRequestController::class, 'create'])->name('meeting_requests.create');
    Route::post('/meeting-requests', [MeetingRequestController::class, 'store'])->name('meeting_requests.store');
    Route::get('/meeting-requests/{id}', [MeetingRequestController::class, 'show'])->name('meeting_requests.show');
    Route::get('/meeting-requests/{id}/edit', [MeetingRequestController::class, 'edit'])->name('meeting_requests.edit');
    Route::patch('/meeting-requests/{id}', [MeetingRequestController::class, 'update'])->name('meeting_requests.update');
    Route::delete('/meeting-requests/{id}', [MeetingRequestController::class, 'destroy'])->name('meeting_requests.destroy');
});

require __DIR__.'/auth.php';
