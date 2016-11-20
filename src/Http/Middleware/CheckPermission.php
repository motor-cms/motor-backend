<?php

namespace Motor\Backend\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class CheckPermission
{

    /**
     * @var
     */
    protected $auth;


    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route        = $request->route()->getName();
        $routeCleaned = str_replace('backend.', '', $route);

        $routeParts = explode('.', $routeCleaned);
        $routeParts = array_reverse($routeParts);

        switch ($routeParts[0]) {
            case 'store':
            case 'create':
            case 'update':
            case 'edit':
            case 'duplicate':
                $routeParts[0] = 'write';
                break;
            case 'destroy':
                $routeParts[0] = 'delete';
                break;
            case 'index':
            case 'show':
                $routeParts[0] = 'read';
                break;
        }

        $routeParts = array_reverse($routeParts);
        $permission = implode('.', $routeParts);

        if ($this->auth->user()->hasRole('SuperAdmin')) {
            return $next($request);
        }
        if ( ! $this->auth->user()->hasPermissionTo($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
