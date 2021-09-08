<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function test()
    {
        return response([
            'message' => 'OK'
        ], Response::HTTP_OK);
    }
}
