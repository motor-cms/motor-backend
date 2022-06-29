<?php

namespace Motor\Backend\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class RenewPassword
 */
class RenewPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)
                ->getUser()->password_last_changed_at == null) {
            return redirect(route('auth.change-password.index'));
        }

        return $next($request);
    }
}
