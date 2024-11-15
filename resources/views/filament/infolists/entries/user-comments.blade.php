


{{-- Show input textarea for new comment --}}

{{-- Button to post comment on click call add comment + on success reload page --}}

{{-- Show default loading comments --}}

{{-- On page load call  /comments api, show the list of comments below --}}

{{-- scripts for api here --}}
{{-- 
<div id="comment-section" data-blog-id="{{ request()->route('blog') }}">
    <textarea id="new-comment" placeholder="Write your comment here..."></textarea>
    <button id="post-comment" onclick="addComment()">Post Comment</button>
</div>

<div id="loading" style="display: none;">Loading comments...</div>
<div id="comments-list" style="display: none;"></div> --}}

{{-- <script>
    
    const blogId = "{{ $getRecord()->id }}";  
    function addComment() {
        const commentContent = document.getElementById("new-comment").value;

        fetch(`/api/blog/${blogId}/add-comment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ content: commentContent })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("new-comment").value = "";
            loadComments();
        })
        .catch(error => console.error("Error adding comment:", error));
    }

    document.addEventListener("DOMContentLoaded", loadComments);

    function loadComments() {
        fetch(`/api/blog/${blogId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            renderComments(data.data.comments);
        })
        .catch(error => console.error("Error loading comments:", error));
    }

    function renderComments(comments) {
        const commentsList = document.getElementById("comments-list");
        commentsList.innerHTML = "";  

        comments.forEach(comment => {
            const commentElement = document.createElement("div");
            commentElement.innerText = comment.content;
            commentsList.appendChild(commentElement);
        });
    }
</script> --}}
{{-- Show input textarea for new comment --}}
<div id="comment-section">
    <textarea id="comment-text" placeholder="Write a comment..." maxlength="500"></textarea>
    <button onclick="addComment()" class="post-comment-btn">Post Comment</button>
</div>

{{-- Loading Comments Placeholder --}}
<div id="loading-comments">
    Loading comments...
</div>

{{-- Comment List --}}
<div id="comments-list"></div>

{{-- Scripts for API calls --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetchComments();
    });

    function fetchComments() {
        const blogId = "{{ $getRecord()->id }}";
        fetch(`/api/blog/${blogId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderComments(data.data.comments);
            } else {
                document.getElementById('loading-comments').innerText = 'Failed to load comments.';
            }
        })
        .catch(error => {
            console.error('Error fetching comments:', error);
        });
    }

    function addComment() {
        const commentText = document.getElementById('comment-text').value;
        if (commentText.trim() === '') return alert('Comment cannot be empty');

        const blogId = "{{ $getRecord()->id }}";
        fetch(`/api/blog/${blogId}/add-comment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: commentText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchComments(); 
                document.getElementById('comment-text').value = ''; 
            } else {
                alert(data.message || 'Failed to add comment');
            }
        })
        .catch(error => {
            console.error('Error adding comment:', error);
        });
    }

    function renderComments(comments) {
        const commentsList = document.getElementById('comments-list');
        commentsList.innerHTML = '';

        comments.forEach(comment => {
            const commentDiv = document.createElement('div');
            commentDiv.classList.add('comment-item');
            commentDiv.innerText = comment.content; 
            commentsList.appendChild(commentDiv);
        });

        document.getElementById('loading-comments').style.display = 'none'; 
    }
</script>

<style>
    #comment-section { margin-bottom: 10px; }
    #comment-text { width: 100%; height: 60px; padding: 8px; }
    #comments-list { margin-top: 10px; }
    .comment-item { padding: 8px; border-bottom: 1px solid #ddd; }
    .post-comment-btn {
        background-color: #4CAF50; 
        color: white;
        padding: 10px 20px; 
        font-size: 16px;
        border: none; 
        border-radius: 5px; 
        cursor: pointer; 
        transition: background-color 0.3s ease, transform 0.2s ease; 
    }

    .post-comment-btn:hover {
        background-color: #45a049; 
        transform: scale(1.05);
    }

    .post-comment-btn:active {
        background-color: #3e8e41; 
        transform: scale(0.98); 
    }   
    #comment-section {
        display: flex; 
        align-items: center; 
        gap: 10px; 
    }
    #comment-text {
        width: 100%; 
        height: 60px; 
        padding: 8px; 
        font-size: 16px; 
        border: 1px solid #ddd; 
        border-radius: 5px;
        resize: vertical; 
    }

    .post-comment-btn {
        background-color: #4CAF50; 
        color: white; 
        padding: 10px 20px; 
        font-size: 16px; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer; 
        transition: background-color 0.3s ease, transform 0.2s ease; 
        flex-shrink: 0; 
    }

    .post-comment-btn:hover {
        background-color: #45a049; 
        transform: scale(1.05); 
    }

    .post-comment-btn:active {
        background-color: #3e8e41; 
        transform: scale(0.98); 
    }
</style>