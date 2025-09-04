<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaLayananController extends Controller
{
    /**
     * Display the kelola layanan page.
     */
    public function index()
    {
        return view('pages.kelola-layanan');
    }
}
