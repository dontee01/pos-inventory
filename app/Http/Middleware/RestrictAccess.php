<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(!$request->session()->has('id')){
        //     return redirect('/');
        // }

        // if(\Session::get('role') != 'admin') {
        //     return redirect('/home');
        // }

        if(empty(\Session::get('id'))){
            // abort(403, 'Unauthorized action.');
            \Session::flash('error', 'Unauthorized access');
            \Session::flush();
            return redirect('/');
        }
        return $next($request);
    }
}
