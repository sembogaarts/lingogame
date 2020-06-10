<?php

namespace App\Http\Middleware;

use App\Helpers\TokenHelper;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class TokenMiddleware
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
        /**
         * Check if the token exists or create a new one
         */
        if(TokenHelper::tokenExists($request)) {
            // Get the token
            $token = TokenHelper::retrieveToken($request);
        } else {
            // Generate a new token
            $token = TokenHelper::newToken();
        }

        /**
         * Check if the user exists
         */
        $user = User::where('token', $token)->first();


        /**
         * Register a new user with the token
         */
        if(!$user) {
            // Create new user
            $user = User::create([
                'token' => $token
            ]);
        }

        /**
         * Login the user
         */
        Auth::login($user);

        /**
         * Attach token to request
         */
        $response = $next($request);

        $response->withCookie(cookie()->forever('token', $token));

        return $response;
    }
}
