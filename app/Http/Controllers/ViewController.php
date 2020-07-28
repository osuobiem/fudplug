<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Feed/Home Page
     */
    public function feed()
    {
        return view('feed');
    }
}
