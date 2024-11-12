<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $blog->title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-4xl">
        <h1 class="text-3xl font-bold text-center">{{ $blog->title }}</h1>
        
        <div class="mt-4 flex justify-center">
            <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" class="rounded-lg w-full max-w-lg h-auto">
        </div>

        <div class="mt-6 text-center">
            <p>{{ $blog->content }}</p>
        </div>

        <div class="mt-4 text-center">
            <h3 class="font-semibold">Tags:</h3>
            <p>{{ $blog->tag }}</p>
        </div>

        <div class="mt-4 text-center">
            <h3 class="font-semibold">Location:</h3>
            <p>{{ $blog->location }}</p>
        </div>

        <div class="mt-4 flex justify-center">
            <a href="{{ route('blog.export_pdf', $blog->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded">Export to PDF</a>
        </div>

        <hr class="my-6">

        <!-- Share Section -->
        <div class="mt-6 text-center">
            <h3 class="text-xl font-semibold mb-2">Share this post</h3>
            <div class="flex justify-center space-x-4">
                <!-- Facebook Share Button -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.view', $blog->id)) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 0H2C.895 0 0 .895 0 2v20c0 1.105.895 2 2 2h10.125V14.3H8.964v-3.4h3.161V8.056c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.465.099 2.795.143v3.24l-1.918.001c-1.504 0-1.794.714-1.794 1.76v2.307h3.587l-.467 3.4h-3.12V24H22c1.105 0 2-.895 2-2V2c0-1.105-.895-2-2-2z"/></svg>
                    <span>Facebook</span>
                </a>

                <!-- Twitter Share Button -->
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.view', $blog->id)) }}&text={{ urlencode($blog->title) }}" target="_blank" class="bg-blue-400 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.643 4.937c-.835.37-1.732.617-2.675.727a4.697 4.697 0 002.049-2.577 9.436 9.436 0 01-2.973 1.14 4.713 4.713 0 00-8.022 4.285A13.36 13.36 0 011.671 3.15a4.703 4.703 0 001.463 6.276 4.646 4.646 0 01-2.134-.591v.06a4.72 4.72 0 003.777 4.622 4.674 4.674 0 01-2.127.08 4.717 4.717 0 004.415 3.29A9.464 9.464 0 010 19.54a13.319 13.319 0 007.194 2.106c8.631 0 13.34-7.155 13.34-13.345 0-.204-.004-.408-.014-.611a9.485 9.485 0 002.323-2.41z"/></svg>
                    <span>Twitter</span>
                </a>

                <!-- Instagram Link (No Direct Sharing Available) -->
                <a href="https://instagram.com" target="_blank" class="bg-pink-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-pink-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c3.204 0 3.584.012 4.85.07 1.258.058 2.125.267 2.935.57a5.94 5.94 0 012.153 1.4 5.94 5.94 0 011.4 2.153c.303.81.512 1.677.57 2.935.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.058 1.258-.267 2.125-.57 2.935a5.94 5.94 0 01-1.4 2.153 5.94 5.94 0 01-2.153 1.4c-.81.303-1.677.512-2.935.57-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.258-.058-2.125-.267-2.935-.57a5.94 5.94 0 01-2.153-1.4 5.94 5.94 0 01-1.4-2.153c-.303-.81-.512-1.677-.57-2.935C.012 15.584 0 15.204 0 12s.012-3.584.07-4.85c.058-1.258.267-2.125.57-2.935a5.94 5.94 0 011.4-2.153A5.94 5.94 0 015.148.57c.81-.303 1.677-.512 2.935-.57C8.416.012 8.796 0 12 0zm0 5.838a6.164 6.164 0 100 12.328 6.164 6.164 0 000-12.328zm6.406-2.244a1.44 1.44 0 100 2.88 1.44 1.44 0 000-2.88zM12 7.347a4.653 4.653 0 100 9.305 4.653 4.653 0 000-9.305z"/></svg>
                    <span>Instagram</span>
                </a>
            </div>
        </div>

        <hr class="my-6">

        <!-- Reactions Section -->
        <div id="reactions-panel" class="mt-4 bg-white p-4 rounded-lg shadow-md text-center">
            <h3 class="text-xl font-semibold mb-4">Reactions</h3>
            <div class="flex justify-center space-x-4">
                <div onclick="addReaction('like')" class="reaction-item cursor-pointer flex items-center">
                    👍 Like <span id="like-count" class="ml-2 text-gray-700">{{ $blog->reactions->like ?? 0 }}</span>
                </div>
                <div onclick="addReaction('happy')" class="reaction-item cursor-pointer flex items-center">
                    😊 Happy <span id="happy-count" class="ml-2 text-gray-700">{{ $blog->reactions->happy ?? 0 }}</span>
                </div>
                <div onclick="addReaction('sad')" class="reaction-item cursor-pointer flex items-center">
                    😢 Sad <span id="sad-count" class="ml-2 text-gray-700">{{ $blog->reactions->sad ?? 0 }}</span>
                </div>
                <div onclick="addReaction('motivating')" class="reaction-item cursor-pointer flex items-center">
                    💪 Motivating <span id="motivating-count" class="ml-2 text-gray-700">{{ $blog->reactions->motivating ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div id="comments" class="mt-4 text-center">
            <h3 class="text-xl font-semibold mb-2">Comments</h3>
            
            <!-- Display Existing Comments -->
            @foreach($blog->comments as $comment)
                <div class="bg-white p-4 rounded-lg shadow mb-2">
                    <p><strong>{{ $comment->user->name }}</strong> <span class="text-gray-600 text-sm">{{ $comment->created_at->diffForHumans() }}</span></p>
                    <p>{{ $comment->content }}</p>
                </div>
            @endforeach

            <!-- Add Comment Form -->
            @auth
                <form id="commentForm" method="POST" action="{{ route('blog.add_comment', $blog->id) }}" class="mt-4">
                    @csrf
                    <textarea name="content" class="w-full p-2 border rounded-lg" rows="3" placeholder="Add your comment..."></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Submit Comment</button>
                </form>
            @else
                <p class="text-gray-600 mt-2">Please <a href="{{ route('login') }}" class="text-blue-500">log in</a> to post a comment.</p>
            @endauth
        </div>
    </div>

    <script>
        function addReaction(type) {
            fetch("{{ route('blog.add_reaction', $blog->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`${type}-count`).textContent = data.count;
                }
            })
            .catch(error => console.error('Error:', error));
        }

        document.getElementById('commentForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload page to display new comment
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
