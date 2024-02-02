<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark-800 dark:text-dark-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display Message Notifications -->
            @if($messages->isEmpty())
                <div class="alert alert-info">
                    Your inbox is empty. Start a chat to view messages.
                </div>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sender</th>
                        <th scope="col">Message</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>
                                @if($message->sender->id === auth()->id())
                                    You
                                @else
                                    {{ $message->sender->name }}
                                @endif
                            </td>
                            <td>{{ $message->message }}</td>
                            <td>
                                <!-- Reply Button/Link -->
                                <button type="button" class="btn btn-primary bg-success" data-toggle="modal" data-target="#replyModal{{ $message->id }}">
                                    Reply
                                </button>
                                <!-- Delete Button/Link -->
                                <button type="button" class="btn btn-danger bg-danger" data-toggle="modal" data-target="#deleteModal{{ $message->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <!-- Reply Modal -->
                        <div class="modal fade" id="replyModal{{ $message->id }}" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel{{ $message->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="replyModalLabel{{ $message->id }}">Reply to {{ $message->sender->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add a form for composing and sending a reply -->
                                        <form action="{{ route('messages.reply', ['message' => $message->id]) }}" method="post">
                                            @csrf
                                            <textarea name="reply" rows="3" class="form-control" placeholder="Compose your reply"></textarea>
                                            <button type="submit" class="btn btn-primary bg-success mt-2">Send Reply</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $message->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $message->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $message->id }}">Delete Message</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this message?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Cancel</button>
                                        <form action="{{ route('messages.delete', ['message' => $message->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger bg-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</x-app-layout>
