<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Models\blog;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blogs/{blog}/export-pdf', [BlogController::class, 'exportPdf'])->name('blog.export_pdf');

Route::get('/user-panel/blogs/{blog}', [BlogController::class, 'show'])->name('blog.view');
Route::get('/blog-map', [BlogController::class, 'mapView'])->name('blog.map');
Route::post('/blogs/{blog}/comments', [BlogController::class, 'addComment'])->name('blog.add_comment');
Route::post('/blogs/{blog}/reactions', [BlogController::class, 'addReaction'])->name('blog.add_reaction');
Route::get('/login', function () {
    return redirect()->route('filament.user.auth.login');
})->name('login');


Route::get('/author/approval-pending', function () {
    return view('author.approval_pending'); 
})->name('author.approval_pending');


