<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaCabangController extends Controller
{
    /**
     * Display the kelola cabang page.
     */
    public function index()
    {
        return view('pages.kelola-cabang');
    }
}
