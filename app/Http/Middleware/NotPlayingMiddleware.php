<?php

namespace App\Http\Middleware;

use App\Helpers\UserHelper;
use Closure;
use Illuminate\Support\Facades\Auth;

class NotPlayingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $userHelper = new UserHelper($user);

        if(!$userHelper->isPlaying()) {
            return $next($request);
        } else {
            return redirect()->route('playGame');
        }
    }
}
