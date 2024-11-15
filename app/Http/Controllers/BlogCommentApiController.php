<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\BlogImpression;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class BlogCommentApiController extends Controller
{

    private function successResponse($data, $message = null, $status = 200) 
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ], $status);
    }

    private function errorResponse($message = null, $status = 200) 
    {
        return $this
            ->status($status)
            ->json([
                'success' => false,
                'message' => $message
            ]);
    }

    public function listComments(Blog $blog)
    {
        $data['comments'] = $blog->comments()->with('user:id,name')->get();
    
        return $this->successResponse($data);
    }
    

    public function addComment(Request $request, Blog $blog)
    {
        if (!auth()->check()) {
            return response()->json([
                'error' => 'Unauthorized. Please log in to add a comment.',
                'authenticated' => auth()->check(),
                'user' => auth()->user(),
            ], 401);
        }

        $userId = auth()->id();

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $data['comment'] = $blog->comments()->create([
            'user_id' => $userId,
            'content' => $request->input('content'),
        ]);

        return $this->successResponse($data, "Comment Created", 201);
    }

    public function addReaction(Request $request, Blog $blog)
    {
        $request->validate(['type' => 'required|string']);

        $reaction = $blog->reactions()->firstOrCreate(['blog_id' => $blog->id]);

        $type = $request->input('type');
        $reaction->increment($type);

        return $this->successResponse(null, "Reaction Created", 201);
    }
  
    
}
