<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/communityforum.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="header">
        <h4><i class="fa-regular fa-comments"></i> Community Forum</h4>
    </div>
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-container">
            <h4>Post a New Topic</h4>
            <form action="{{ route('patient.communityforum.store') }}" method="POST" id="postTopicForm">
                @csrf
                <div class="input-group mb-3">
                    <textarea type="text" class="form-control" id="topic" name="topic" placeholder="Type here..." required></textarea>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Post Topic</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="forum-container">
            @foreach ($communityforums as $communityforum)
                <div class="tweet-card">
                    <div class="tweet-header">
                        <div>
                            <span class="username">{{ $communityforum->user->name }}</span>
                            <span class="timestamp">{{ $communityforum->created_at->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</span>
                        </div>
                    </div>
                    <div class="tweet-content">
                        <div class="editing-content" id="edit-form-{{ $communityforum->id }}" style="display: none;">
                            <form method="post" action="{{ route('patient.updatedCommunityforum', $communityforum->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="topic" name="topic" placeholder="What's on your mind?" value="{{ old('topic', $communityforum->topic) }}" required>
                                </div>
                                <div class="update-cancel-buttons">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-info cancel-btn" onclick="cancelEdit({{ $communityforum->id }})">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <div class="non-editing-content" id="non-edit-form-{{ $communityforum->id }}" style="display: block;">
                            <p>{{ $communityforum->topic }}</p>
                        </div>
                    </div>
                    <!-- Add Comment Form -->
                    <div class="add-comment-form">
                        <form action="{{ route('patient.addComment', $communityforum->id) }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <textarea class="form-control" id="comment" name="comment" placeholder="Add a comment..." required></textarea>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tweet-actions">
                        <button class="btn-action" onclick="toggleComments({{ $communityforum->id }})"><i class="fa-regular fa-message"></i> Comments</button>
                        @if(Auth::id() === $communityforum->user_id || Auth::user()->is_patient)
                            <button class="btn-action" onclick="editTopic({{ $communityforum->id }})"><i class="fa-solid fa-pen"></i> Edit</button>
                            <form method="post" action="{{ route('patient.deleteCommunityforum', $communityforum->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action" onclick="return confirm('Are you sure you want to delete this post?')"><i class="fa-regular fa-trash-can"></i> Delete</button>
                            </form>
                        @endif
                    </div>

                    <!-- Comments Section -->
                    <div id="comments-section-{{ $communityforum->id }}" class="comments-section d-none">
                        @foreach ($communityforum->comments as $comment)
                            <div class="comment-card">
                                <div class="comment-header">
                                    <div>
                                        <span class="username">{{ $comment->user->name }}</span>
                                        <span class="timestamp">{{ $comment->created_at->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="comment-content">
                                    <div class="editing-content" id="edit-comment-form-{{ $comment->id }}" style="display: none;">
                                        <form method="post" action="{{ route('patient.updatedComment', $comment->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <input type="text" class="form-control" id="comment" name="comment" placeholder="Edit your comment" value="{{ old('comment', $comment->comment) }}" required>
                                            </div>
                                            <div class="update-cancel-buttons">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-info cancel-btn" onclick="cancelEditComment({{ $comment->id }})">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="non-editing-content" id="non-edit-comment-form-{{ $comment->id }}" style="display: block;">
                                        <p>{{ $comment->comment }}</p>
                                    </div>
                                </div>
                                <div class="comment-actions">
                                    @if(Auth::id() === $comment->user_id || Auth::user()->is_patient)
                                        <button class="btn-action" onclick="editComment({{ $comment->id }})"><i class="fa-solid fa-pen"></i> Edit</button>
                                        <form method="post" action="{{ route('patient.deleteComment', $comment->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action" onclick="return confirm('Are you sure you want to delete this comment?')"><i class="fa-regular fa-trash-can"></i> Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            {{ $communityforums->links() }}
        </div>
    </div>
    <script>
        function toggleComments(forumId) {
            var commentsSection = document.getElementById('comments-section-' + forumId);
            commentsSection.classList.toggle('d-none');
        }

        function editTopic(forumId) {
            document.getElementById('edit-form-' + forumId).style.display = 'block';
            document.getElementById('non-edit-form-' + forumId).style.display = 'none';
        }

        function cancelEdit(forumId) {
            document.getElementById('edit-form-' + forumId).style.display = 'none';
            document.getElementById('non-edit-form-' + forumId).style.display = 'block';
        }

        function editComment(commentId) {
            document.getElementById('edit-comment-form-' + commentId).style.display = 'block';
            document.getElementById('non-edit-comment-form-' + commentId).style.display = 'none';
        }

        function cancelEditComment(commentId) {
            document.getElementById('edit-comment-form-' + commentId).style.display = 'none';
            document.getElementById('non-edit-comment-form-' + commentId).style.display = 'block';
        }
    </script>
    
</body>
</html>

@section('title')
    Community Forum
@endsection

</x-app-layout>