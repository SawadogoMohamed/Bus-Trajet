<?php


// app/Http/Middleware/TrackOnlineUsers.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrackOnlineUsers
{
    public function handle(Request $request, Closure $next)
    {
        $sessionId = session()->getId();

        // Stocke la session dans le cache avec expiration de 5 minutes
        Cache::put('online_user_'.$sessionId, now(), now()->addMinutes(5));

        return $next($request);
    }
}
