<!-- resources/views/matches/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark-800 dark:text-dark-200 leading-tight">
            {{ __('Potential Matches') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        
            <!-- Check if user has skills -->
            @if(!$user->skills->isEmpty())
                <!-- Check if there are potential matches -->
                @if(!$potentialMatches->isEmpty())
                    <h1>Here are potential matches for {{ $user->name }}</h1>
                @else
                    <p class="alert alert-info">
                    Brace yourself! Our matchmaking gnomes are currently on a coffee break ☕, but fear not, they're diligently searching for your perfect match.
                     Check back in a bit for the grand reveal of your potential mentorship mate!
                    </p>
                @endif

                <div class="card-deck">
                    @foreach($potentialMatches as $match)
                        <div class="card clickable" data-toggle="modal" data-target="#userModal{{ $match->id }}">
                            <!-- User Profile Picture -->
                            <div class="p-6 flex items-center justify-center">
                                @if($match->profile_picture_url)
                                    <img class="w-20 h-20 object-cover rounded-full" src="{{ $match->profile_picture_url }}" alt="Profile Picture">
                                @else
                                    <img class="w-20 h-20 object-cover rounded-full" src="{{ asset('placeholder_image.jpg') }}" alt="Placeholder Image">
                                @endif
                            </div>

                            <div class="p-6 text-black dark:text-dark">
                                <!-- User Name -->
                                <h5 class="text-xl font-semibold">{{ $match->name }}</h5>
                                <!-- User Role: Mentor or Mentee -->
                                <p class="mb-2 text-sm">
                                    @if ($match->role === 'mentor')
                                        Mentor
                                    @elseif ($match->role === 'mentee')
                                        Mentee
                                    @else
                                        Unknown Role
                                    @endif
                                </p>
                                <!-- Button to open modal -->
                                <button type="button" class="btn btn-primary bg-primary" data-toggle="modal" data-target="#userModal{{ $match->id }}">
                                    View Details
                                </button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="userModal{{ $match->id }}" tabindex="-1" role="dialog" aria-labelledby="userModalLabel{{ $match->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="userModalLabel{{ $match->id }}">Profile of {{ $match->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Display additional details here -->
                                        <p>Bio: {{ $match->bio }}</p>

                                        <!-- Add buttons or forms for sending a message and initiating a mentorship request -->
                                        <!-- Example button for sending a message -->
                                        <button type="button" class="btn btn-success bg-success" data-toggle="modal" data-target="#sendMessageModal{{ $match->id }}">Send Message</button>

                                        <!-- New Modal for Sending Messages -->
                                        <div class="modal fade" id="sendMessageModal{{ $match->id }}" tabindex="-1" role="dialog" aria-labelledby="sendMessageModalLabel{{ $match->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="sendMessageModalLabel{{ $match->id }}">Send Message to {{ $match->name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form for Sending Messages -->
                                                        <form method="post" action="{{ route('messages.store') }}">
                                                            @csrf
                                                            <input type="hidden" name="receiver_id" value="{{ $match->id }}">

                                                            <div class="form-group">
                                                                <label for="message">Message:</label>
                                                                <textarea id="message" name="message" class="form-control" rows="3" required></textarea>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary bg-primary">Send Message</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Example button for initiating a mentorship request -->
                                        <button class="btn btn-info" data-toggle="modal" data-target="#initiateMentorshipModal{{ $match->id }}">Initiate Mentorship Request</button>

                                        <!-- New Modal for Initiating Mentorship Request -->
                                        <div class="modal fade" id="initiateMentorshipModal{{ $match->id }}" tabindex="-1" role="dialog" aria-labelledby="initiateMentorshipModalLabel{{ $match->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="initiateMentorshipModalLabel{{ $match->id }}">Initiate Mentorship Request to {{ $match->name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form for Initiating Mentorship Request -->
                                                        <form method="post" action="{{ route('mentorship_requests.store') }}">
                                                            @csrf
                                                            <input type="hidden" name="mentee_id" value="{{ auth()->user()->id }}">
                                                            <input type="hidden" name="mentor_id" value="{{ $match->id }}">
                                                            <div class="form-group">
                                                                <label for="message">Mentorship Pitch:</label>
                                                                <textarea id="message" name="message" class="form-control" rows="3" required></textarea>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary bg-primary">Initiate Request</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary bg-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="alert alert-warning">
                    To view potential matches, please update your skills in the profile section.
                </p>
            @endif
        </div>
    </div>
</x-app-layout>
