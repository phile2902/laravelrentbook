<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Book;

use App\Http\Requests;

class ProfileController extends Controller
{
    public function show_profile_page($id)
    {
        $user  = User::find($id);
        $books = $user->books;
        return view('profile', ['user' => $user, 'books' => $books]);
    }
}
