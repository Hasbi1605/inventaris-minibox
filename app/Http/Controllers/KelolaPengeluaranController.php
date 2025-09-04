<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaPengeluaranController extends Controller
{
    /**
     * Display the kelola pengeluaran page.
     */
    public function index()
    {
        return view('pages.kelola-pengeluaran');
    }
}
