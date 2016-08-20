<?php

namespace App\Http\Controllers;

use App;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;

class DashboardController extends Controller
{
    public function show_page()
    {
        $users = User::all();
        return view('dashboard', compact('users'));
    }
}
