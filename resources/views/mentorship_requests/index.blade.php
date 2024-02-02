<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark-800 dark:text-dark-200 leading-tight">
            {{ __('Mentorship Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Received Mentorship Requests Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Received Mentorship Requests</h3>
                    @if(count($receivedRequests) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50">Name</th>
                                    <th class="px-6 py-3 bg-gray-50">Role</th>
                                    <th class="px-6 py-3 bg-gray-50">Message</th>
                                    <th class="px-6 py-3 bg-gray-50">Status</th>
                                    <th class="px-6 py-3 bg-gray-50">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivedRequests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->mentee->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->mentee->role }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->message }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap" style="color: @if($request->status === 'pending') orange @elseif($request->status === 'accepted') green @else red @endif">{{ $request->status }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($request->status === 'pending')
                                                <button class="btn btn-success" onclick="acceptRequest({{ $request->id }})">Accept</button>
                                                <button class="btn btn-danger" onclick="declineRequest({{ $request->id }})">Decline</button>
                                            @elseif ($request->status === 'accepted')
                                                <button class="btn btn-primary" onclick="requestMeeting({{ $request->id }})">Request Meeting</button>
                                            @else
                                                <!-- Display a different message or action for declined requests -->
                                                <span>{{ $request->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No received mentorship requests.</p>
                    @endif
                    </div>
                </div>

               
            <!-- Sent Mentorship Requests Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Sent Mentorship Requests</h3>
                    @if(count($sentRequests) > 0)
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Name</th>
                                    <th class="py-2 px-4 border-b">Role</th>
                                    <th class="py-2 px-4 border-b">Status</th>
                                    <th class="py-2 px-4 border-b">Sent Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sentRequests as $request)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $request->mentor->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $request->mentor->role }}</td>
                                        <td class="py-2 px-4 border-b" style="color: @if($request->status === 'pending') orange @elseif($request->status === 'accepted') green @else red @endif">{{ $request->status }}</td>
                                        <td class="py-2 px-4 border-b">{{ $request->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No sent mentorship requests.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        function acceptRequest(requestId) {
            // Send an AJAX request to update the request status to 'accepted'
            axios.post('/update-request-status/' + requestId, {
                status: 'accepted'
            })
            .then(function (response) {
                // Handle the success response from the server
                console.log('Request accepted successfully:', response.data);

                // Optionally, you can update the UI or perform other actions after accepting
            })
            .catch(function (error) {
                // Handle errors from the server or AJAX request
                console.error('Error accepting request:', error);
            });
        }

        function declineRequest(requestId) {
            // Send an AJAX request to update the request status to 'declined'
            axios.post('/update-request-status/' + requestId, {
                status: 'declined'
            })
            .then(function (response) {
                // Handle the success response from the server
                console.log('Request declined successfully:', response.data);

                // Optionally, you can update the UI or perform other actions after declining
            })
            .catch(function (error) {
                // Handle errors from the server or AJAX request
                console.error('Error declining request:', error);
            });
        }

        function requestMeeting(requestId) {
            // Add logic here to handle the meeting request, e.g., open a modal or perform other actions
            console.log('Meeting requested for request ID:', requestId);
        }
    </script>
</x-app-layout>
