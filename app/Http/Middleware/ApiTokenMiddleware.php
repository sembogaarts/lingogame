<?php

namespace App\Http\Middleware;

use App\Helpers\TokenHelper;
use App\User;
use Closure;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;

class ApiTokenMiddleware
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
            abort(403, 'No token found');
        }

        /**
         * Check if the user exists
         */
        $user = User::where('token', $token)->first();


        /**
         * Register a new user with the token
         */
        if(!$user) {
            abort(403, 'Token is not valid');
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
