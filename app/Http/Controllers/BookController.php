<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BookController extends Controller
{
    public function show_create_new_books_page()
    {
        return view('createnewbooks');
    }
}
