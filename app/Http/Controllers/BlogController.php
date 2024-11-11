<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show(Blog $blog)
    {
        return view('filament.user-panel.pages.blog-view', compact('blog'));
    }
    public function exportPdf(Blog $blog)
    {
        $pdf = PDF::loadView('filament.user-panel.pages.blog-view', compact('blog'));
        return $pdf->download($blog->title . '.pdf');
    }
    public function addComment(Request $request, Blog $blog)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);
        $blog->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);
        return response()->json(['message' => 'Comment added successfully.']);
    }
    public function addReaction(Request $request, Blog $blog)
    {
        $request->validate(['type' => 'required|string']);

        $reaction = $blog->reactions()->firstOrCreate(['blog_id' => $blog->id]);

        // Increment the specified reaction type
        $type = $request->input('type');
        $reaction->increment($type);

        return response()->json(['success' => true, 'count' => $reaction->$type]);
    }


}
