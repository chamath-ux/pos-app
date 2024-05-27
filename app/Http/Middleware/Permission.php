<?php

namespace App\Http\Middleware;

use Closure;
use CheckPermission;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class Permission extends BaseController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$permission): Response
    {
        if(!CheckPermission::hasPermission($permission))
        {
            return $this->sendError('You have no permission for this action','',403);
        }
        return $next($request);
    }
}
