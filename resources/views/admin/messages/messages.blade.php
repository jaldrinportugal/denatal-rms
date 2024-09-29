<x-app-layout>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body>
    <div class="chat-container">
        <div class="users-list" id="users">
            <div>
                <h1><i class="fa-regular fa-comment-dots"></i> Messages</h1>
            </div>
            <form action="{{ route('admin.messages.search') }}" method="GET">
                <div class="relative w-full">
                    <input type="text" name="query" placeholder="Search" class="w-full h-10 px-3 rounded-full focus:ring-2 border border-gray-300 focus:outline-none focus:border-blue-500">
                    <button type="submit" class="absolute top-0 end-0 p-2.5 pr-3 text-sm font-medium h-full text-white bg-blue-700 rounded-e-full border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </form>
            <br>
            @foreach ($users as $user)
                <div class="user-item" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
                    <div>
                        {{ $user->name }}
                        <div class="recent-message" id="recent-{{ $user->name }}"></div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="chat-box" id="chat-box">
            @foreach ($users as $user)
                <div id="chat-panel-{{ $user->name }}" class="chat-messages">
                    <!-- Chat messages for {{ $user->name }} -->
                    @foreach ($messages as $message)
                        @if ($message->sender_id == auth()->id() && $message->recipient_id == $user->id)
                            <div class="admin">
                                <p>You</p>
                                <p>{{ $message->message }}</p>
                                </div>
                        @elseif ($message->sender_id == $user->id && $message->recipient_id == auth()->id())
                            <div class="others">
                                <p>{{ $user->name }}</p>
                                <p>{{ $message->message }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach

            <form method="post" action="{{ route('admin.messages.store') }}" class="chat-input">
                @csrf
                <input type="hidden" id="recipient_id" name="recipient_id" value="">
                <input placeholder="Type your message..." rows="3" type="text" class="form-control" id="message" name="message" required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event listeners to user items
        document.querySelectorAll('.user-item').forEach(item => {
            item.addEventListener('click', function() {
                selectUser(item.dataset.username, item.dataset.userid);
            });
        });

        // Select the default user
        let firstUser = document.querySelector('.user-item');
        if (firstUser) {
            selectUser(firstUser.dataset.username, firstUser.dataset.userid);
        }
    });

    function selectUser(username, userid) {
        selectedUser = username;
        document.querySelectorAll('.user-item').forEach(item => {
            item.classList.remove('selected');
        });
        document.querySelector(`.user-item[data-username="${username}"]`).classList.add('selected');
        showChatPanel(username);

        // Set the recipient_id in the form
        document.getElementById('recipient_id').value = userid;
    }

    function showChatPanel(username) {
        // Hide all chat panels
        document.querySelectorAll('.chat-messages').forEach(panel => {
            panel.style.display = 'none';
        });

        // Show the selected user's chat panel
        let chatPanel = document.getElementById(`chat-panel-${username}`);
        if (chatPanel) {
            chatPanel.style.display = 'block';
        } 
    }
</script>
    
</html>
</body>

@section('title')
    Messages
@endsection

</x-app-layout>