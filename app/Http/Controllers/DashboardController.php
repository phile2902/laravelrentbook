<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Http\Requests;

class DashboardController extends Controller
{
    public function show_page()
    {
        return view('dashboard');
    }
}
