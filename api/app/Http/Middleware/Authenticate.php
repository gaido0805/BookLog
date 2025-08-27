<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // APIリクエストの場合はリダイレクトを返さない
        if ($request->expectsJson()) {
            return null;
        }
        
        // Webリクエストの場合のみリダイレクト
        return route('login');
    }
}
