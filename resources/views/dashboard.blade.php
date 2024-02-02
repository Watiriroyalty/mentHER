<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark-800 dark:text-dark-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-center mb-8">
                    <h3 class="text-xl font-semibold text-dark-800 dark:text-dark-200">🚀 Welcome to mentHER!</h3>
                    <p class="text-sm text-gray-600 dark:text-dark-400 mb-4">You're the trailblazer & fearless tech explorer, stepping into a world of women who rock the tech scene!! 🌟</p>
                    <p class="text-sm text-gray-600 dark:text-dark-400">"Embrace the tech adventure – where mentors sprinkle magic on eager minds, creating a symphony of innovation and curiosity! 🌈✨"</p>
                    <p class="text-sm text-gray-600 dark:text-dark-400">"Mentorship is a shared journey, where the wisdom of the experienced mingles with the curiosity of the eager."</p>
                </div>
                <div class="card-deck">
                @foreach ($users as $user)
                <!-- Skip the logged-in user -->
                    @if ($user->id !== auth()->user()->id)
                    <div class="card clickable" data-toggle="modal" data-target="#userModal{{ $user->id }}">
                        <!-- User Profile Picture -->
                        <div class="p-6 flex items-center justify-center">
                            @if($user->profile_picture_url)
                            <img class="w-20 h-20 object-cover rounded-full" src="{{ $user->profile_picture_url }}" alt="Profile Picture">
                            @else
                                <img class="w-20 h-20 object-cover rounded-full" src="{{ asset('placeholder_image.jpg') }}" alt="Placeholder Image">
                            @endif
                        </div>

                        <div class="p-6 text-black dark:text-dark">
                            <!-- User Name -->
                            <h5 class="text-xl font-semibold">{{ $user->name }}</h5>

                            <!-- User Role: Mentor or Mentee -->
                            <p class="mb-2 text-sm">
                                @if ($user->role === 'mentor')
                                    Mentor
                                @elseif ($user->role === 'mentee')
                                    Mentee
                                @else
                                    Unknown Role
                                @endif
                            </p>
                         
                            <!-- Button to open modal -->
                            <button type="button" class="btn btn-primary bg-primary" data-toggle="modal" data-target="#userModal{{ $user->id }}">
                                View Details
                            </button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="userModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userModalLabel{{ $user->id }}">Hey you? I am {{ $user->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Display additional details here -->
                                     <!-- User Skills -->
                            <p class="mb-4"> Skills: 
                                @foreach ($user->skills as $skill)
                                    <span class="badge badge-primary mr-2"> {{ $skill->name }}</span>
                                @endforeach
                            </p>
                                    <p>Bio: {{ $user->bio }}</p>

                                    
                                    <!-- Button for sending a message -->
                                    <button type="button" class="btn btn-success bg-success" data-toggle="modal" data-target="#sendMessageModal{{ $user->id }}">Send Message</button>

                                <!-- New Modal for Sending Messages -->
                                <div class="modal fade" id="sendMessageModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="sendMessageModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sendMessageModalLabel{{ $user->id }}">Send Message to {{ $user->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form for Sending Messages -->
                                                <form method="post" action="{{ route('messages.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">

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
                     <button class="btn btn-info" data-toggle="modal" data-target="#initiateMentorshipModal{{ $user->id }}" 
        @if (($user->role === 'mentor' && auth()->user()->role === 'mentee') || ($user->role === 'mentee' && auth()->user()->role === 'mentor'))
            {{-- Show the button only if the roles match the expected mentor-mentee or mentee-mentor --}}
        @else
            style="display: none;" {{-- Hide the button if the roles do not match --}}
        @endif
    >Initiate Mentorship Request</button>
                <!-- New Modal for Initiating Mentorship Request -->
                <div class="modal fade" id="initiateMentorshipModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="initiateMentorshipModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="initiateMentorshipModalLabel{{ $user->id }}">Initiate Mentorship Request to {{ $user->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Form for Initiating Mentorship Request -->
                                <form method="post" action="{{ route('mentorship_requests.store') }}">
                                    @csrf
                                    <input type="hidden" name="mentee_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="mentor_id" value="{{ $user->id }}">
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
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
