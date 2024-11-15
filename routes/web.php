<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogCommentApiController;
use App\Models\blog;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blogs/{blog}/export-pdf', [BlogController::class, 'exportPdf'])->name('blog.export_pdf');

Route::get('/user-panel/blogs/{blog}', [BlogController::class, 'show'])->name('blog.view');
Route::get('/blog-map', [BlogController::class, 'mapView'])->name('blog.map');


Route::middleware('auth')->group(function () {
    Route::post('/blog/{blog}/add-comment', [BlogController::class, 'addComment'])->name('blog.add_comment');
});

Route::post('/blogs/{blog}/reactions', [BlogController::class, 'addReaction'])->name('blog.add_reaction');

Route::get('/login', function () {
    return redirect()->route('filament.user.auth.login');
})->name('login');


Route::get('/author/approval-pending', function () {
    return view('author.approval_pending'); 
})->name('author.approval_pending');

Route::middleware('auth:users')->prefix('api')->group(function () {
    Route::post('/blog/{blog}/comments', [BlogCommentApiController::class, 'listComments'])->name('api.blog.listComments');
    Route::post('/blog/{blog}/add-comment', [BlogCommentApiController::class, 'addComment'])->name('api.blog.addComment');
    Route::post('/blog/{blog}/add-reaction', [BlogCommentApiController::class, 'addReaction'])->name('api.blog.addReaction');
    // Route::delete('/blog/{blog}/delete-comment/{comment}', [BlogCommentApiController::class, 'deleteComment'])->name('blog.deleteComment');
    Route::delete('/comments/{comment}', [BlogCommentApiController::class, 'deleteComment'])->name('api.comments.delete');

});