<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RtlController extends Controller
{
    /**
     * Display the RTL page.
     */
    public function index()
    {
        return view('pages.rtl');
    }
}
