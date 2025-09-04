<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * Display the billing page.
     */
    public function index()
    {
        return view('pages.billing');
    }
}
