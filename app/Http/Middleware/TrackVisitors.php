<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;
use Carbon\Carbon;

class TrackVisitors
{
    public function handle($request, Closure $next)
    {
        Visitor::updateOrCreate(
            ['ip' => $request->ip()],
            ['last_activity' => Carbon::now()]
        );

        return $next($request);
    }
}
