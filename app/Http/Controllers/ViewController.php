<?php

namespace App\Http\Controllers;

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
