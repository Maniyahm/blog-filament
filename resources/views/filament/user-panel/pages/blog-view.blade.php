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

    <div class="container mx-auto px-4 py-6 bg-white rounded-lg shadow-lg w-full max-w-3xl">
        <h1 class="text-3xl font-bold text-center">{{ $blog->title }}</h1>
        
        <div class="mt-4 flex justify-center">
            <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" class="rounded-lg w-full max-w-2xl">
        </div>

        <div class="mt-6 text-center">
            <p>{{ $blog->content }}</p>
        </div>

        <div class="mt-4 text-center">
            <h3 class="font-semibold">Title:</h3>
            <p>{{ $blog->title }}</p>
        </div>

        <div class="mt-4 text-center">
            <h3 class="font-semibold">Location:</h3>
            <p>{{ $blog->location }}</p>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('blog.export_pdf', $blog->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded">Export to PDF</a>
        </div>

        <hr class="my-6">

        <!-- Reactions Section -->
        <div id="reactions-panel" class="mt-4 bg-gray-50 p-4 rounded-lg shadow-md text-center">
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
        <div id="comments" class="mt-6">
            <h3 class="text-xl font-semibold mb-2 text-center">Comments</h3> 
            @foreach($blog->comments as $comment)
                <div class="bg-white p-4 rounded-lg shadow mb-2">
                    <p>{{ $comment->content }}</p>    
                </div>
            @endforeach
            <div>
                <form id="commentForm" method="POST" action="{{ route('blog.add_comment', $blog->id) }}" class="mt-4">
                    @csrf
                    <textarea name="content" class="w-full p-2 border rounded" placeholder="Add your comment..."></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Submit Comment</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addReaction(reaction) {
            fetch('/reactions/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ blog_id: {{ $blog->id }}, reaction: reaction })
            }).then(response => response.json()).then(data => {
                // Update reaction counts on page
            });
        }

        // AJAX Comment Submission
        document.getElementById('commentForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => response.json()).then(data => {
                location.reload();
            }).catch(error => console.error('Error:', error));
        });

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
    </script>
</body>
</html>
