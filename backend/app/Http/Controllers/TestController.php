<?php

namespace App\Http\Controllers;

class TestController
{
    public function index()
    {
        return response()->json([
            'message' => 'Hello, this is a test API response!'
        ]);
    }
}
