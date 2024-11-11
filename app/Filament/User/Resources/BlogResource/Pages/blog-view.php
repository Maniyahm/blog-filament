@extends('filament::layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold">{{ $blog->title }}</h1>
        
        <div class="mt-4">
            <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" class="w-full h-auto rounded-lg">
        </div>

        <div class="mt-6">
            <p>{{ $blog->content }}</p>
        </div>

        <div class="mt-4">
            <h3 class="font-semibold">Tags:</h3>
            <p>{{ $blog->tag }}</p>
        </div>

        <div class="mt-4">
            <h3 class="font-semibold">Location:</h3>
            <p>{{ $blog->location }}</p>
        </div>

        <div class="mt-4">
            <a href="{{ route('blog.export_pdf', $blog->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded">Export to PDF</a>
        </div>

        <hr class="my-6">

        <div id="comments">
            <h3 class="text-xl font-semibold mb-2">Comments</h3>
            @foreach($blog->comments as $comment)
                <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
            @endforeach

            <form id="commentForm" method="POST" action="{{ route('comment.add', $blog->id) }}" class="mt-4">
                @csrf
                <textarea name="content" class="w-full p-2 border rounded" placeholder="Add your comment..."></textarea>
                <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Submit Comment</button>
            </form>
        </div>

        <hr class="my-6">

        <div id="reactions" class="mt-4">
            <h3 class="text-xl font-semibold mb-2">Reactions</h3>
            <button onclick="addReaction('happy')" class="px-4 py-2 bg-yellow-500 text-white rounded">😊 Happy</button>
            <button onclick="addReaction('sad')" class="px-4 py-2 bg-blue-500 text-white rounded">😢 Sad</button>
            <button onclick="addReaction('motivating')" class="px-4 py-2 bg-green-500 text-white rounded">💪 Motivating</button>
        </div>
    </div>

    <script>
        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => response.json()).then(data => {
                // Update comments list with new comment
                // Reload or dynamically insert comment here
            });
        });

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
                // Reload or dynamically update reactions here
            });
        }
    </script>
@endsection
