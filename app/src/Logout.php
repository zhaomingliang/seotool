<?php

namespace App;

class Logout
{

    public function __invoke($request, $response, $next)
    {

        \RKA\Session::destroy();
        \RKA\Session::regenerate();
        $response = $next($request, $response);
        return $response;

    }

}
