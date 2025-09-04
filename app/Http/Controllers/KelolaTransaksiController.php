<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaTransaksiController extends Controller
{
    /**
     * Display the kelola transaksi page.
     */
    public function index()
    {
        return view('pages.kelola-transaksi');
    }
}
