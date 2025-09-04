<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaInventarisController extends Controller
{
    /**
     * Display the kelola inventaris page.
     */
    public function index()
    {
        return view('pages.kelola-inventaris');
    }
}
