<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark-800 dark:text-dark-200 leading-tight">
            {{ __('Request a Meeting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Request Meeting Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Fill in the Meeting Request Details</h3>

                    <!-- Add your meeting request form here -->
                    <form method="post" action="{{ route('meeting_requests.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="recipient_id" :value="__('Recipient')" />
                            <x-select id="recipient_id" class="block mt-1 w-full" name="recipient_id" :options="$recipients" required />
                            <x-input-error :messages="$errors->get('recipient_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="message" :value="__('Message')" />
                            <x-text-input id="message" class="block mt-1 w-full" type="text" name="message" :value="old('message')" required />
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="proposed_datetime" :value="__('Proposed Datetime')" />
                            <x-datetime-picker id="proposed_datetime" class="block mt-1 w-full" name="proposed_datetime" :value="old('proposed_datetime')" required />
                            <x-input-error :messages="$errors->get('proposed_datetime')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Send Meeting Request') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add any additional scripts or logic specific to the meeting request form
    </script>
</x-app-layout>
