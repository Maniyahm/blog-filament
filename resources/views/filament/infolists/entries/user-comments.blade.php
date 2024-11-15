{{-- Show input textarea for new comment --}}

{{-- Button to post comment on click call add comment + on success reload page --}}

{{-- Show default loading comments --}}

{{-- On page load call  /comments api, show the list of comments below --}}

{{-- scripts for api here --}}

{{-- Show input textarea for new comment --}}
<div id="comment-section">
    <textarea id="comment-text" placeholder="Write a comment..." maxlength="500"></textarea>
    <button onclick="addComment()" class="post-comment-btn">Post Comment</button>
</div>
<div id="comments-container">
    <div id="all-comments" class="comments-column">
        <h3>All Comments</h3>
        <div id="comments-list"></div>
    </div>
    <div id="user-comments" class="comments-column">
        <h3>Your Comments</h3>
        <div id="user-comments-list"></div>
    </div>
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
                // Separate comments by user ID
                const userId = "{{ auth()->id() }}"; // Logged-in user ID
                const userComments = data.data.comments.filter(comment => comment.user_id == userId);
                const otherComments = data.data.comments.filter(comment => comment.user_id != userId);

                // Render both sections
                renderComments(otherComments, 'comments-list'); // Left section (all comments)
                renderComments(userComments, 'user-comments-list'); // Right section (user comments)
            } else {
                console.error('Failed to load comments:', data.message);
            }
        })
        .catch(error => console.error('Error fetching comments:', error));
}

function addComment() {
    const commentText = document.getElementById('comment-text').value.trim();
    if (!commentText) return alert('Comment cannot be empty');

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
                fetchComments(); // Reload comments
                document.getElementById('comment-text').value = ''; // Clear the input
            } else {
                alert(data.message || 'Failed to add comment');
            }
        })
        .catch(error => console.error('Error adding comment:', error));
}

function renderComments(comments, targetElementId) {
    const commentsList = document.getElementById(targetElementId);
    commentsList.innerHTML = ''; // Clear the current list

    comments.forEach(comment => {
        const commentDiv = document.createElement('div');
        commentDiv.classList.add('comment-item');

        const userName = document.createElement('span');
        userName.classList.add('comment-username');
        userName.innerText = comment.user.name; // Display user name

        const content = document.createElement('p');
        content.classList.add('comment-content');
        content.innerText = comment.content; 
        
        const timestamp = document.createElement('span');
        timestamp.classList.add('comment-timestamp');
        timestamp.innerText = `Posted on: ${new Date(comment.created_at).toLocaleString()}`;

        commentDiv.appendChild(userName);
        commentDiv.appendChild(content);

        commentsList.appendChild(commentDiv);
    });
}


    
</script>

<style>
    #comments-container {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.comments-column {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    background-color: #f9f9f9;
    max-height: 500px;
    overflow-y: auto;
}

.comments-column h3 {
    margin: 0 0 10px;
    font-size: 18px;
    font-weight: bold;
    border-bottom: 2px solid #ddd;
    padding-bottom: 5px;
}

.comment-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.comment-item:last-child {
    border-bottom: none;
}

.comment-username {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.comment-content {
    margin: 0;
}

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