<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark-800 dark:text-dark-200 leading-tight">
            {{ __('Meeting Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Display Meeting Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Meeting Requests</h3>

                    @if(count($meetingRequests) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50">Requester</th>
                                    <th class="px-6 py-3 bg-gray-50">Recipient</th>
                                    <th class="px-6 py-3 bg-gray-50">Message</th>
                                    <th class="px-6 py-3 bg-gray-50">Status</th>
                                    <th class="px-6 py-3 bg-gray-50">Proposed Datetime</th>
                                    <th class="px-6 py-3 bg-gray-50">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($meetingRequests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->requester->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->recipient->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->message }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap" style="color: @if($request->status === 'pending') orange @elseif($request->status === 'accepted') green @else red @endif">{{ $request->status }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->proposed_datetime }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($request->status === 'pending')
                                                <button class="btn btn-success" onclick="acceptRequest({{ $request->id }})">Accept</button>
                                                <button class="btn btn-danger" onclick="declineRequest({{ $request->id }})">Decline</button>
                                            @elseif ($request->status === 'accepted')
                                                <button class="btn btn-primary" onclick="scheduleMeeting({{ $request->id }})">Schedule Meeting</button>
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
                        <p>No meeting requests available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function acceptRequest(requestId) {
            // Implement logic to accept the meeting request
            console.log('Meeting request accepted:', requestId);
        }

        function declineRequest(requestId) {
            // Implement logic to decline the meeting request
            console.log('Meeting request declined:', requestId);
        }

        function scheduleMeeting(requestId) {
            // Implement logic to schedule the meeting
            console.log('Meeting scheduled for request ID:', requestId);
        }
    </script>
</x-app-layout>
