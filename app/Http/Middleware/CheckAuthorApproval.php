<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthorApproval
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('authors')->check()) {
            $author = Auth::guard('authors')->user();
            
            if ($author->approved === 'unapproved') {
                return redirect()->route('author.approval_pending');
            }
            return $next($request);
        }
        return redirect()->route('login');
    }
}
