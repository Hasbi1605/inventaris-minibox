<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display the laporan page.
     */
    public function index()
    {
        return view('pages.laporan.index');
    }
}
