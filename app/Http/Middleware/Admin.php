<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = session()->get('user');

        if (!$user) {
            return redirect()->route('login.view')->with('error', 'Please login first');
        }

        $prefix = $request->route()->getPrefix();


        if (($prefix === '/admin' && $user['user_type'] == 0) || ($prefix === '/institute' && $user['user_type'] == 2)) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'Unauthorized access');

    }
}
