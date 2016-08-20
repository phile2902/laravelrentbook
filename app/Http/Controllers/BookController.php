<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;

class BookController extends Controller
{
    public function show_create_new_books_page()
    {
        $categories = Category::all();
        return view('createnewbooks', compact('categories'));
    }
}
