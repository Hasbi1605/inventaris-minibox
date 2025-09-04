<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TablesController extends Controller
{
    /**
     * Display the tables page.
     */
    public function index()
    {
        return view('pages.tables');
    }
}
