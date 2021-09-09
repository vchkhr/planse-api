<?php

namespace App\Http\Middleware;

use Closure;

class API
{

    public function handle($request, Closure $next)
    {

        $response = $next($request);
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Content-Range, Content-Disposition, Content-Description, X-Auth-Token');
        $response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Allow-Origin', 'https://planse.vchkhr.com');
        return $response;
    }
}
